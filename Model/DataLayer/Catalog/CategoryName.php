<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Catalog;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCatalogConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Registry;

class CategoryName
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerCatalogConfig */
    private $dataLayerCatalogConfig;
    /** @var RouteHelper */
    private $routeHelper;
    /** @var Registry */
    private $registry;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerCatalogConfig $dataLayerCatalogConfig
     * @param RouteHelper $routeHelper
     * @param Registry $registry
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerCatalogConfig $dataLayerCatalogConfig,
                                RouteHelper $routeHelper,
                                Registry $registry)
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerCatalogConfig = $dataLayerCatalogConfig;
        $this->routeHelper = $routeHelper;
        $this->registry = $registry;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $this->googleTagManager->addDataLayerVariable('categoryName', $this->getCategoryName());
    }

    private function getCategoryName()
    {
        /** @var CategoryInterface $category */
        $category = $this->registry->registry('current_category');
        if (!$category)
        {
            return '';
        }

        return $category->getName();
    }

    private function isEnabled()
    {
        return $this->dataLayerCatalogConfig->isCategoryNameEnabled() && $this->routeHelper->isCategory();
    }

}