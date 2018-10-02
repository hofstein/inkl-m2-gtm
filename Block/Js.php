<?php

namespace Inkl\GoogleTagManager\Block;

use Inkl\GoogleTagManager\Helper\Config\GeneralConfig;
use Magento\Framework\View\Element\Template;

class Js extends Template
{
    private $jsFile;
    /** @var GeneralConfig */
    private $generalConfig;

    /**
     * @param Template\Context $context
     * @param GeneralConfig $generalConfig
     * @param array $data
     */
    public function __construct(Template\Context $context,
                                GeneralConfig $generalConfig,
                                array $data = [])
    {
        parent::__construct($context, $data);

        $this->jsFile = $data['js_file'] ?? null;
        $this->generalConfig = $generalConfig;
    }

    protected function _toHtml()
    {
        if (!$this->generalConfig->isEnabled())
        {
            return '';
        }

        return sprintf('<script type="text/x-magento-init">%s</script>', json_encode(['*' => ['inkl_googletagmanager/' . $this->jsFile => []]]));
    }

}