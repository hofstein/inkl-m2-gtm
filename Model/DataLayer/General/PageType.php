<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\General;

use Inkl\GoogleTagManager\Helper\Config\DataLayerGeneralConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;

class PageType
{
    /** @var GoogleTagManager */
    protected $googleTagManager;
    /** @var DataLayerGeneralConfig */
    protected $dataLayerGeneralConfig;
    /** @var RouteHelper */
    protected $routeHelper;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerGeneralConfig $dataLayerGeneralConfig
     * @param RouteHelper $routeHelper
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerGeneralConfig $dataLayerGeneralConfig,
                                RouteHelper $routeHelper)
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerGeneralConfig = $dataLayerGeneralConfig;
        $this->routeHelper = $routeHelper;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $pageType = $this->determine();
        if ($pageType)
        {
            $this->googleTagManager->addDataLayerVariable('pageType', $pageType, 'page_type');
        }
    }

    protected function determine()
    {
        if ($this->routeHelper->isHome()) return 'home';
        if ($this->routeHelper->isCategory()) return 'category';
        if ($this->routeHelper->isSearch()) return 'searchresults';
        if ($this->routeHelper->isProduct()) return 'product';
        if ($this->routeHelper->isCart()) return 'cart';
        if ($this->routeHelper->isPurchase()) return 'purchase';
        if ($this->routeHelper->isNotFound()) return 'notfound';

        return 'other';
    }

    protected function isEnabled()
    {
        return $this->dataLayerGeneralConfig->isPageTypeEnabled();
    }

}
