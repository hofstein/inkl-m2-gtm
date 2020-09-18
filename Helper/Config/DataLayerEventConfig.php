<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class DataLayerEventConfig extends AbstractHelper
{
    const XML_PATH_ADD_TO_CART = 'inkl_googletagmanager/datalayer_event/addtocart';
    const XML_PATH_PRODUCT_CLICKS = 'inkl_googletagmanager/datalayer_event/product_clicks';
    const XML_PATH_CHECKOUT_FUNNEL = 'inkl_googletagmanager/datalayer_event/checkout_funnel';

    public function isAddToCartEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ADD_TO_CART, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isProductClicksEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_CLICKS, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isCheckoutFunnelEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CHECKOUT_FUNNEL, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
