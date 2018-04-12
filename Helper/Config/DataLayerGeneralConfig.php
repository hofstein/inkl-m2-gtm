<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class DataLayerGeneralConfig extends AbstractHelper
{
    const XML_PATH_PAGE_TYPE = 'inkl_googletagmanager/datalayer_general/page_type';
    const XML_PATH_CURRENCY_CODE = 'inkl_googletagmanager/datalayer_general/currency_code';
    const XML_PATH_LOCALE_CODE = 'inkl_googletagmanager/datalayer_general/locale_code';

    public function isPageTypeEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PAGE_TYPE, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isCurrencyCodeEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CURRENCY_CODE, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isLocaleCodeEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CURRENCY_CODE, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
