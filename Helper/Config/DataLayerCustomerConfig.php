<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class DataLayerCustomerConfig extends AbstractHelper
{
    const XML_PATH_EMAIL = 'inkl_googletagmanager/datalayer_customer/email';
    const XML_PATH_EMAIL_SHA1 = 'inkl_googletagmanager/datalayer_customer/email_sha1';

    public function isEmailEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_EMAIL, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isEmailSha1Enabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_EMAIL_SHA1, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
