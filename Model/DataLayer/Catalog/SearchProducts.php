<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Catalog;

use Inkl\GoogleTagManager\Helper\Config\DataLayerCatalogConfig;
use Inkl\GoogleTagManager\Helper\PriceHelper;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Framework\View\LayoutInterface;

class SearchProducts
{
	/** @var GoogleTagManager */
	private $googleTagManager;
	/** @var DataLayerCatalogConfig */
	private $dataLayerCatalogConfig;
	/** @var RouteHelper */
	private $routeHelper;
	/** @var LayoutInterface */
	private $layout;
	/** @var PriceHelper */
	private $priceHelper;

	/**
	 * @param GoogleTagManager $googleTagManager
	 * @param DataLayerCatalogConfig $dataLayerCatalogConfig
	 * @param RouteHelper $routeHelper
	 * @param LayoutInterface $layout
	 * @param PriceHelper $priceHelper
	 */
	public function __construct(GoogleTagManager $googleTagManager,
	                            DataLayerCatalogConfig $dataLayerCatalogConfig,
	                            RouteHelper $routeHelper,
	                            LayoutInterface $layout,
	                            PriceHelper $priceHelper
	)
	{
		$this->googleTagManager = $googleTagManager;
		$this->dataLayerCatalogConfig = $dataLayerCatalogConfig;
		$this->routeHelper = $routeHelper;
		$this->layout = $layout;
		$this->priceHelper = $priceHelper;
	}

	public function handle()
	{
		if (!$this->isEnabled())
		{
			return;
		}

		$searchProducts = $this->getSearchProducts();

		$this->googleTagManager->addDataLayerVariable('searchProducts', $searchProducts);
	}

	private function getSearchProducts()
	{
		$searchProductListBlock = $this->layout->getBlock('search_result_list');
		if (!$searchProductListBlock) return [];

		$searchProducts = [];
		foreach ($searchProductListBlock->getLoadedProductCollection() as $product)
		{
			$searchProducts[] = [
				'id' => $product->getSku(),
				'name' => $product->getName(),
				'price' => $this->priceHelper->getPriceExclTax($product)
			];
		}

		return $searchProducts;
	}

	private function isEnabled()
	{
		return $this->dataLayerCatalogConfig->isSearchProductsEnabled() && $this->routeHelper->isSearch();
	}

}