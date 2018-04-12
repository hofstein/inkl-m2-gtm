<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Catalog;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCatalogConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Framework\App\Request\Http as HttpRequest;

class SearchKeyword
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerCatalogConfig */
    private $dataLayerCatalogConfig;
    /** @var RouteHelper */
    private $routeHelper;
    /** @var HttpRequest */
    private $httpRequest;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerCatalogConfig $dataLayerCatalogConfig
     * @param RouteHelper $routeHelper
     * @param HttpRequest $httpRequest
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerCatalogConfig $dataLayerCatalogConfig,
                                RouteHelper $routeHelper,
                                HttpRequest $httpRequest
    )
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerCatalogConfig = $dataLayerCatalogConfig;
        $this->routeHelper = $routeHelper;
        $this->httpRequest = $httpRequest;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $this->googleTagManager->addDataLayerVariable('searchKeyword', $this->httpRequest->getParam('q'));
    }

    private function isEnabled()
    {
        return $this->dataLayerCatalogConfig->isSearchKeywordEnabled() && $this->routeHelper->isSearch();
    }

}