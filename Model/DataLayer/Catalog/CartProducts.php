<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Catalog;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCatalogConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Checkout\Model\Session;

class CartProducts
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerCatalogConfig */
    private $dataLayerCatalogConfig;
    /** @var RouteHelper */
    private $routeHelper;
    /** @var Session */
    private $session;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerCatalogConfig $dataLayerCatalogConfig
     * @param RouteHelper $routeHelper
     * @param Session $session
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerCatalogConfig $dataLayerCatalogConfig,
                                RouteHelper $routeHelper,
                                Session $session
    )
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerCatalogConfig = $dataLayerCatalogConfig;
        $this->routeHelper = $routeHelper;
        $this->session = $session;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $cartProducts = $this->getCartProducts();

        $this->googleTagManager->addDataLayerVariable('cartProducts', $cartProducts);
    }

    private function getCartProducts()
    {
        $cartProducts = [];

        foreach ($this->session->getQuote()->getAllVisibleItems() as $quoteItem)
        {
            $sku = $quoteItem->getSku();

            $cartProductData = [
                'id' => $sku,
                'name' => $quoteItem->getName(),
                'price' => round($quoteItem->getPriceInclTax(), 2),
                'quantity' => 0
            ];

            if (!isset($cartProducts[$sku]))
            {
                $cartProducts[$sku] = $cartProductData;
            }

            $cartProducts[$sku]['quantity'] += $quoteItem->getQty();
        }

        return array_values($cartProducts);
    }

    private function isEnabled()
    {
        return $this->dataLayerCatalogConfig->isCartProductsEnabled() && $this->routeHelper->isCart();
    }

}