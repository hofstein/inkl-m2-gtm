<?php

namespace Inkl\GoogleTagManager\Block;

use Inkl\GoogleTagManager\Helper\Config\GeneralConfig;
use Inkl\GoogleTagManagerLib\Schema\ContainerId;
use Magento\Framework\View\Element\Template;
use Inkl\GoogleTagManagerLib\GoogleTagManager;

class Tag extends Template
{
    /** @var GeneralConfig */
    private $generalConfig;
    /** @var GoogleTagManager */
    private $googleTagManager;

    /**
     * @param Template\Context $context
     * @param GeneralConfig $generalConfig
     * @param GoogleTagManager $googleTagManager
     * @param array $data
     */
    public function __construct(Template\Context $context,
                                GeneralConfig $generalConfig,
                                GoogleTagManager $googleTagManager,
                                array $data = [])
    {
        parent::__construct($context, $data);

        $this->generalConfig = $generalConfig;
        $this->googleTagManager = $googleTagManager;
    }

    protected function _toHtml()
    {
        return $this->googleTagManager->renderTag(new ContainerId($this->generalConfig->getContainerId()));
    }

}