<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Ecommerce;

use Inkl\GoogleTagManager\Helper\Config\DataLayerEcommerceConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Checkout\Model\Session;
use Magento\Store\Model\StoreManagerInterface;

class Cart
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerEcommerceConfig */
    private $dataLayerEcommerceConfig;
    /** @var RouteHelper */
    private $routeHelper;
    /** @var StoreManagerInterface */
    private $storeManager;
    /** @var Session */
    private $session;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerEcommerceConfig $dataLayerEcommerceConfig
     * @param RouteHelper $routeHelper
     * @param StoreManagerInterface $storeManager
     * @param Session $session
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerEcommerceConfig $dataLayerEcommerceConfig,
                                RouteHelper $routeHelper,
                                StoreManagerInterface $storeManager,
                                Session $session)
    {

        $this->googleTagManager = $googleTagManager;
        $this->dataLayerEcommerceConfig = $dataLayerEcommerceConfig;
        $this->routeHelper = $routeHelper;
        $this->storeManager = $storeManager;
        $this->session = $session;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $lastCartProducts = $this->getLastCartProducts();
        $cartProducts = $this->getCartProducts();

        $actionList = $this->createActionList($lastCartProducts, $cartProducts);
        foreach ($actionList as $event => $products)
        {
            if (count($products) === 0)
            {
                continue;
            }

            $type = ($event == 'addToCart' ? 'add' : 'remove');

            $this->googleTagManager->addDataLayerVariable('ecommerce', [
                'currencyCode' => $this->storeManager->getStore()->getCurrentCurrency()->getCode(),
                $type => [
                    'products' => $products
                ]
            ], 'ecommerce_' . $event);

            $this->googleTagManager->addDataLayerVariable('event', $event);
        }

        $this->setLastCartProducts($cartProducts);
    }

    private function createActionList($lastCartProducts, $cartProducts)
    {

        $actionList = ['addToCart' => [], 'removeFromCart' => []];
        foreach ($cartProducts as $cartProductData)
        {
            $key = $this->buildProductKey($cartProductData);

            // non existing product
            if (!isset($lastCartProducts[$key]))
            {
                $actionList['addToCart'][] = $cartProductData;
            }

            // existing product - check qty
            if (isset($lastCartProducts[$key]))
            {
                // add diff
                if ($lastCartProducts[$key]['quantity'] < $cartProductData['quantity'])
                {

                    $cartProductData['quantity'] = $cartProductData['quantity'] - $lastCartProducts[$key]['quantity'];

                    $actionList['addToCart'][] = $cartProductData;

                    unset($lastCartProducts[$key]);

                    continue;
                }

                // dec diff
                if ($lastCartProducts[$key]['quantity'] > $cartProductData['quantity'])
                {
                    $cartProductData['quantity'] = $lastCartProducts[$key]['quantity'] - $cartProductData['quantity'];

                    $actionList['removeFromCart'][] = $cartProductData;

                    unset($lastCartProducts[$key]);

                    continue;
                }
            }

            unset($lastCartProducts[$key]);
        }

        // removed products
        foreach ($lastCartProducts as $cartProductData)
        {
            $actionList['removeFromCart'][] = $cartProductData;
        }

        return $actionList;
    }

    private function setLastCartProducts(array $lastCartProducts)
    {
        $this->session->setData('gtm_last_cart', $lastCartProducts);
    }

    private function getLastCartProducts()
    {
        return (array)$this->session->getData('gtm_last_cart');
    }

    private function getCartProducts()
    {
        $cartProducts = [];
        foreach ($this->session->getQuote()->getAllVisibleItems() as $quoteItem)
        {
            $cartProductData = [
                'id' => $quoteItem->getSku(),
                'name' => $quoteItem->getName(),
                'price' => round($quoteItem->getPriceInclTax(), 2),
                'quantity' => 0
            ];

            $key = $this->buildProductKey($cartProductData);
            if (!isset($cartProducts[$key]))
            {
                $cartProducts[$key] = $cartProductData;
            }

            $cartProducts[$key]['quantity'] += $quoteItem->getQty();
        }

        return $cartProducts;
    }

    /**
     * @param array $cartProductData
     * @return string
     */
    private function buildProductKey($cartProductData)
    {
        return md5(implode('#', [
            $cartProductData['id'],
            $cartProductData['name'],
            $cartProductData['price']
        ]));
    }

    private function isEnabled()
    {
        return $this->dataLayerEcommerceConfig->isCartEnabled() && $this->routeHelper->isCart();
    }
}
