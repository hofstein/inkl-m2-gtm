<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Ecommerce;

use Inkl\GoogleTagManager\Helper\Config\DataLayerEcommerceConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Checkout\Model\Session;
use Magento\Store\Model\StoreManagerInterface;

class Purchase
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

        $order = $this->session->getLastRealOrder();

        if (!$order)
        {
            return;
        }

        $ecommerce = [
            'purchase' => [
                'actionField' => $this->getActionField($order),
                'products' => $this->getProducts($order)
            ]
        ];

        $this->googleTagManager->addDataLayerVariable('ecommerce', $ecommerce, 'ecommerce_purchase');
    }

    protected function getActionField(\Magento\Sales\Model\Order $order)
    {
        return [
            'id' => $order->getIncrementId(),
            'affiliation' => 'Online Shop',
            'revenue' => round($order->getSubtotal(), 2),
            'tax' => round($order->getTaxAmount(), 2),
            'shipping' => round($order->getShippingAmount(), 2),
            'coupon' => (string)$order->getCouponCode(),
	        'email' => $order->getCustomerEmail()
        ];
    }

    protected function getProducts(\Magento\Sales\Model\Order $order)
    {
        $products = [];
        foreach ($order->getAllVisibleItems() as $orderItem)
        {
            $products[] = [
                'id' => $orderItem->getSku(),
                'name' => $orderItem->getName(),
                'price' => round($orderItem->getPrice(), 2),
                'quantity' => (int)$orderItem->getQtyOrdered()
            ];
        }

        return $products;
    }

    protected function isEnabled()
    {
        return $this->dataLayerEcommerceConfig->isPurchaseEnabled() && $this->routeHelper->isPurchase();
    }

}
