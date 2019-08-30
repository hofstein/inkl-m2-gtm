<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Catalog;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCatalogConfig;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Framework\View\LayoutInterface;

class SearchNumResults
{
	/** @var GoogleTagManager */
	private $googleTagManager;
	/** @var DataLayerCatalogConfig */
	private $dataLayerCatalogConfig;
	/** @var RouteHelper */
	private $routeHelper;
	/** @var LayoutInterface */
	private $layout;

	/**
	 * @param GoogleTagManager $googleTagManager
	 * @param DataLayerCatalogConfig $dataLayerCatalogConfig
	 * @param RouteHelper $routeHelper
	 * @param LayoutInterface $layout
	 */
	public function __construct(GoogleTagManager $googleTagManager,
	                            DataLayerCatalogConfig $dataLayerCatalogConfig,
	                            RouteHelper $routeHelper,
	                            LayoutInterface $layout
	)
	{
		$this->googleTagManager = $googleTagManager;
		$this->dataLayerCatalogConfig = $dataLayerCatalogConfig;
		$this->routeHelper = $routeHelper;
		$this->layout = $layout;
	}

	public function handle()
	{
		if (!$this->isEnabled())
		{
			return;
		}

		$this->googleTagManager->addDataLayerVariable('searchNumResults', $this->getSearchNumResults());
	}

	private function getSearchNumResults()
	{
		$searchProductListBlock = $this->layout->getBlock('search_result_list');
		if (!$searchProductListBlock) return 0;

		return $searchProductListBlock->getLoadedProductCollection()->getSize();
	}

	private function isEnabled()
	{
		return $this->dataLayerCatalogConfig->isSearchNumResultsEnabled() && $this->routeHelper->isSearch();
	}

}