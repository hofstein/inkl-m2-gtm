<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Ecommerce;

use Inkl\GoogleTagManager\Helper\Config\DataLayerEventConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Checkout\Model\Session;
use Magento\Store\Model\StoreManagerInterface;

class Checkout
{
	/** @var GoogleTagManager */
	private $googleTagManager;
	/** @var DataLayerEventConfig */
	private $dataLayerEventConfig;
	/** @var RouteHelper */
	private $routeHelper;
	/** @var StoreManagerInterface */
	private $storeManager;
	/** @var Session */
	private $session;

	/**
	 * @param GoogleTagManager $googleTagManager
	 * @param DataLayerEventConfig $dataLayerEventConfig
	 * @param RouteHelper $routeHelper
	 * @param StoreManagerInterface $storeManager
	 * @param Session $session
	 */
	public function __construct(GoogleTagManager $googleTagManager,
	                            DataLayerEventConfig $dataLayerEventConfig,
	                            RouteHelper $routeHelper,
	                            StoreManagerInterface $storeManager,
	                            Session $session)
	{

		$this->googleTagManager = $googleTagManager;
		$this->dataLayerEventConfig = $dataLayerEventConfig;
		$this->routeHelper = $routeHelper;
		$this->storeManager = $storeManager;
		$this->session = $session;
	}

	public function handle()
	{
		if (!$this->isEnabled())
		{
			return;
		}

		$dataLayerData = [
			'event' => 'checkout',
			'ecommerce' => [
				'checkout' => [
					'actionField' => [
						'step' => 1,
					],
					'products' => $this->getCartProducts()
				]
			]
		];

		$this->googleTagManager->addDataLayerVariable(null, $dataLayerData);
	}

	private function getCartProducts()
	{
		$cartProducts = [];
		foreach ($this->session->getQuote()->getAllVisibleItems() as $quoteItem)
		{
			$cartProducts[] = [
				'id' => $quoteItem->getSku(),
				'name' => $quoteItem->getName(),
				'price' => round($quoteItem->getPrice(), 2),
				'quantity' => $quoteItem->getQty()
			];
		}

		return $cartProducts;
	}

	private function isEnabled()
	{
		return $this->dataLayerEventConfig->isCheckoutFunnelEnabled() && $this->routeHelper->isCheckout();
	}
}
