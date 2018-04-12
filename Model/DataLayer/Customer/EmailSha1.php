<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Customer;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCustomerConfig;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Stdlib\CookieManagerInterface;

class EmailSha1
{
    /** @var DataLayerCustomerConfig */
    private $dataLayerCustomerConfig;
    /** @var CustomerSession */
    private $customerSession;
    /** @var CookieManagerInterface */
    private $cookieManager;

    /**
     * @param DataLayerCustomerConfig $dataLayerCustomerConfig
     * @param CustomerSession $customerSession
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(DataLayerCustomerConfig $dataLayerCustomerConfig,
                                CustomerSession $customerSession,
                                CookieManagerInterface $cookieManager)
    {
        $this->dataLayerCustomerConfig = $dataLayerCustomerConfig;
        $this->customerSession = $customerSession;
        $this->cookieManager = $cookieManager;
    }

    public function handle()
    {
        if (!$this->isEnabled())
        {
            return;
        }

        $customerEmailSha1 = '';
        if ($this->customerSession->isLoggedIn())
        {
            $customerEmailSha1 = sha1(strtolower($this->customerSession->getCustomer()->getEmail()));
        }

        $this->cookieManager->setPublicCookie('dataLayerCustomerEmailSha1', $customerEmailSha1);
    }

    private function isEnabled()
    {
        return $this->dataLayerCustomerConfig->isEmailEnabled();
    }
}
