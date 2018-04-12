<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\General;

use Inkl\GoogleTagManager\Helper\Config\DataLayerGeneralConfig;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Store\Model\StoreManagerInterface;

class CurrencyCode
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerGeneralConfig */
    private $dataLayerGeneralConfig;
    /** @var StoreManagerInterface */
    private $storeManager;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerGeneralConfig $dataLayerGeneralConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerGeneralConfig $dataLayerGeneralConfig,
                                StoreManagerInterface $storeManager)
    {
        $this->googleTagManager = $googleTagManager;
        $this->dataLayerGeneralConfig = $dataLayerGeneralConfig;
        $this->storeManager = $storeManager;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $this->googleTagManager->addDataLayerVariable('currencyCode', $this->storeManager->getStore()->getCurrentCurrency()->getCode());
    }

    private function isEnabled()
    {
        return $this->dataLayerGeneralConfig->isCurrencyCodeEnabled();
    }
}
