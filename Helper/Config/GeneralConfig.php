<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class GeneralConfig extends AbstractHelper
{
    const XML_PATH_ENABLED = 'inkl_googletagmanager/general/enabled';
    const XML_PATH_CONTAINER_ID = 'inkl_googletagmanager/general/container_id';

    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getContainerId($storeId = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CONTAINER_ID, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
