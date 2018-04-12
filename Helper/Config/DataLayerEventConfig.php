<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class DataLayerEventConfig extends AbstractHelper
{
    const XML_PATH_ADD_TO_CART = 'inkl_googletagmanager/event/addtocart';

    public function isAddToCartEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ADD_TO_CART, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
