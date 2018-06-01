<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Catalog;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCatalogConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutInterface;

class CategoryProducts
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerCatalogConfig */
    private $dataLayerCatalogConfig;
    /** @var RouteHelper */
    private $routeHelper;
    /** @var Registry */
    private $registry;
    /** @var LayoutInterface */
    private $layout;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerCatalogConfig $dataLayerCatalogConfig
     * @param RouteHelper $routeHelper
     * @param Registry $registry
     * @param LayoutInterface $layout
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerCatalogConfig $dataLayerCatalogConfig,
                                RouteHelper $routeHelper,
                                Registry $registry,
                                LayoutInterface $layout)
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerCatalogConfig = $dataLayerCatalogConfig;
        $this->registry = $registry;
        $this->routeHelper = $routeHelper;
        $this->layout = $layout;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $categoryProducts = $this->getCategoryProducts();

        $this->googleTagManager->addDataLayerVariable('categoryProducts', $categoryProducts);
    }

    private function getCategoryProducts()
    {
        /** @var CategoryInterface $category */
        $category = $this->registry->registry('current_category');
        if (!$category || $category->getDisplayMode() == 'PAGE')
        {
            return [];
        }

        $productListBlock = $this->layout->getBlock('category.products.list');
        if (!$productListBlock) return [];

        $categoryProducts = [];
        foreach ($productListBlock->getLoadedProductCollection() as $product)
        {
            $categoryProducts[] = [
                'id' => $product->getSku(),
                'name' => $product->getName(),
                'price' => round($product->getPriceInfo()->getPrice(\Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE)->getAmount()->getBaseAmount(), 2),
            ];
        }

        return $categoryProducts;
    }

    private function isEnabled()
    {
        return $this->dataLayerCatalogConfig->isCategoryProductsEnabled() && $this->routeHelper->isCategory();
    }

}