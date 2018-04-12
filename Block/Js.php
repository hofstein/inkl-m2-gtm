<?php

namespace Inkl\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template;

class Js extends Template
{
    private $jsFile;

    public function __construct(Template\Context $context,
                                array $data = [])
    {
        parent::__construct($context, $data);

        $this->jsFile = $data['js_file'] ?? null;
    }

    protected function _toHtml()
    {
        return sprintf('<script type="text/x-magento-init">%s</script>', json_encode(['*' => ['inkl_googletagmanager/' . $this->jsFile => []]]));
    }

}