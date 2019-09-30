<?php

namespace Inkl\GoogleTagManager\Helper;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Cms\Model\Page as CmsPage;

class RouteHelper
{
    /** @var HttpRequest */
    private $httpRequest;
    /** @var CmsPage */
    private $cmsPage;

    /**
     * @param HttpRequest $httpRequest
     * @param CmsPage $cmsPage
     */
    public function __construct(HttpRequest $httpRequest,
                                CmsPage $cmsPage
    )
    {
        $this->httpRequest = $httpRequest;
        $this->cmsPage = $cmsPage;
    }

    public function getPath()
    {
        return sprintf('%s/%s/%s', $this->httpRequest->getModuleName(), $this->httpRequest->getControllerName(), $this->httpRequest->getActionName());
    }

    public function isHome()
    {
        if ($this->getPath() === 'cms/index/index' && $this->cmsPage->getIdentifier() == 'home') return true;

        return false;
    }

    public function isCategory()
    {
        return $this->getPath() === 'catalog/category/view';
    }

    public function isSearch()
    {
        return $this->getPath() === 'catalogsearch/result/index';
    }

    public function isProduct()
    {
        return $this->getPath() === 'catalog/product/view';
    }

    public function isCart()
    {
        return $this->getPath() === 'checkout/cart/index';
    }

    public function isCheckout()
    {
        return $this->getPath() === 'checkout/onepage/index'
            || $this->getPath() === 'onestepcheckout/index/index';
    }

    public function isPurchase()
    {
        return ($this->getPath() === 'checkout/onepage/success');
    }

    public function isNotFound()
    {
        return ($this->getPath() === 'cms/index/noRoute');
    }

}