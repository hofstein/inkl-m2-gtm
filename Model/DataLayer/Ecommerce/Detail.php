<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Ecommerce;

use Inkl\GoogleTagManager\Helper\Config\DataLayerEcommerceConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Framework\Registry;

class Detail
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerEcommerceConfig */
    private $dataLayerEcommerceConfig;
    /** @var RouteHelper */
    private $routeHelper;
    /** @var Registry */
    private $registry;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerEcommerceConfig $dataLayerEcommerceConfig
     * @param RouteHelper $routeHelper
     * @param Registry $registry
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerEcommerceConfig $dataLayerEcommerceConfig,
                                RouteHelper $routeHelper,
                                Registry $registry)
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerEcommerceConfig = $dataLayerEcommerceConfig;
        $this->routeHelper = $routeHelper;
        $this->registry = $registry;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $product = $this->registry->registry('current_product');
        if (!$product)
        {
            return;
        }

        $ecommerce = [
            'detail' => [
                'actionField' => [],
                'products' => [[
                    'id' => $product->getSku(),
                    'name' => $product->getName(),
                    'price' => round($product->getPriceInfo()->getPrice(\Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE)->getAmount()->getBaseAmount(), 2),
                ]]
            ]
        ];

        $this->googleTagManager->addDataLayerVariable('ecommerce', $ecommerce, 'ecommerce_detail');
    }

    private function isEnabled()
    {
        return $this->dataLayerEcommerceConfig->isDetailEnabled() && $this->routeHelper->isProduct();
    }

}
