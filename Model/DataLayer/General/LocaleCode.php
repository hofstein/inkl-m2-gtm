<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\General;

use Inkl\GoogleTagManager\Helper\Config\DataLayerGeneralConfig;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Framework\Locale\ResolverInterface;

class LocaleCode
{
    /** @var GoogleTagManager */
    private $googleTagManager;
    /** @var DataLayerGeneralConfig */
    private $dataLayerGeneralConfig;
    /** @var ResolverInterface */
    private $resolver;

    /**
     * @param GoogleTagManager $googleTagManager
     * @param DataLayerGeneralConfig $dataLayerGeneralConfig
     * @param ResolverInterface $resolver
     */
    public function __construct(GoogleTagManager $googleTagManager,
                                DataLayerGeneralConfig $dataLayerGeneralConfig,
                                ResolverInterface $resolver
    )
    {

        $this->googleTagManager = $googleTagManager;
        $this->dataLayerGeneralConfig = $dataLayerGeneralConfig;
        $this->resolver = $resolver;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $this->googleTagManager->addDataLayerVariable('localeCode', $this->resolver->getLocale());
    }

    private function isEnabled()
    {
        return $this->dataLayerGeneralConfig->isLocaleCodeEnabled();
    }
}
