<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\General;

use Inkl\GoogleTagManager\Helper\Config\DataLayerGeneralConfig;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Braintree\Model\LocaleResolver;

class LocaleCode
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerGeneralConfig */
    private $dataLayerGeneralConfig;
    /** @var LocaleResolver */
    private $localeResolver;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerGeneralConfig $dataLayerGeneralConfig
     * @param LocaleResolver $localeResolver
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerGeneralConfig $dataLayerGeneralConfig,
                                LocaleResolver $localeResolver
    )
    {

        $this->googleTagManager = $googleTagManager;
        $this->dataLayerGeneralConfig = $dataLayerGeneralConfig;
        $this->localeResolver = $localeResolver;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $this->googleTagManager->addDataLayerVariable('localeCode', $this->localeResolver->getLocale());
    }

    private function isEnabled()
    {
        return $this->dataLayerGeneralConfig->isLocaleCodeEnabled();
    }
}
