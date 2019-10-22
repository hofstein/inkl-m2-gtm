<?php

namespace Inkl\GoogleTagManager\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class DataLayerCatalogConfig extends AbstractHelper
{
    const XML_PATH_CATEGORY_ID = 'inkl_googletagmanager/datalayer_catalog/category_id';
    const XML_PATH_CATEGORY_NAME = 'inkl_googletagmanager/datalayer_catalog/category_name';
    const XML_PATH_CATEGORY_PRODUCTS = 'inkl_googletagmanager/datalayer_catalog/category_products';

    const XML_PATH_SEARCH_KEYWORD = 'inkl_googletagmanager/datalayer_catalog/search_keyword';
    const XML_PATH_SEARCH_PRODUCTS = 'inkl_googletagmanager/datalayer_catalog/search_products';
    const XML_PATH_SEARCH_NUM_RESULTS = 'inkl_googletagmanager/datalayer_catalog/search_num_results';

    const XML_PATH_CART_PRODUCTS = 'inkl_googletagmanager/datalayer_catalog/cart_products';

    public function isCategoryIdEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CATEGORY_ID, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isCategoryNameEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CATEGORY_NAME, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isCategoryProductsEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CATEGORY_PRODUCTS, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isSearchKeywordEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SEARCH_KEYWORD, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isSearchProductsEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SEARCH_PRODUCTS, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isSearchNumResultsEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SEARCH_NUM_RESULTS, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isCartProductsEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CART_PRODUCTS, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
