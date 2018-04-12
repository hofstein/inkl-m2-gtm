<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class DataLayerEcommerceConfig extends AbstractHelper
{
    const XML_PATH_DETAIL = 'inkl_googletagmanager/datalayer_ecommerce/detail';
    const XML_PATH_CART = 'inkl_googletagmanager/datalayer_ecommerce/cart';
    const XML_PATH_PURCHASE = 'inkl_googletagmanager/datalayer_ecommerce/purchase';

    public function isDetailEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_DETAIL, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isCartEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CART, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isPurchaseEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PURCHASE, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
