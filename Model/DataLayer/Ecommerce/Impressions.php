<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\Ecommerce;

use Inkl\GoogleTagManager\Helper\Config\DataLayerEcommerceConfig;
use Inkl\GoogleTagManager\Helper\PriceHelper;
use Inkl\GoogleTagManager\Helper\RouteHelper;
use Inkl\GoogleTagManagerLib\GoogleTagManager;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutInterface;

class Impressions
{
	/** @var GoogleTagManager */
	private $googleTagManager;
	/** @var DataLayerEcommerceConfig */
	private $dataLayerEcommerceConfig;
	/** @var RouteHelper */
	private $routeHelper;
	/** @var Registry */
	private $registry;
	/** @var LayoutInterface */
	private $layout;
	/** @var PriceHelper */
	private $priceHelper;

	/**
	 * @param GoogleTagManager $googleTagManager
	 * @param DataLayerEcommerceConfig $dataLayerEcommerceConfig
	 * @param RouteHelper $routeHelper
	 * @param Registry $registry
	 * @param LayoutInterface $layout
	 * @param PriceHelper $priceHelper
	 */
	public function __construct(GoogleTagManager $googleTagManager,
	                            DataLayerEcommerceConfig $dataLayerEcommerceConfig,
	                            RouteHelper $routeHelper,
	                            Registry $registry,
	                            LayoutInterface $layout,
	                            PriceHelper $priceHelper)
	{
		$this->googleTagManager = $googleTagManager;
		$this->dataLayerEcommerceConfig = $dataLayerEcommerceConfig;
		$this->registry = $registry;
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

		$impressionProducts = [];
		if ($this->routeHelper->isCategory())
		{
			/** @var CategoryInterface $category */
			$category = $this->registry->registry('current_category');
			if ($category && $category->getDisplayMode() != 'PAGE')
			{
				$impressionProducts = $this->getImpressionProducts('category.products.list', 'Category Results', $category->getName());
			}
		}

		if ($this->routeHelper->isSearch())
		{
			$impressionProducts = $this->getImpressionProducts('search_result_list', 'Search Results');
		}

		if (count($impressionProducts) === 0)
		{
			return;
		}

		$ecommerce = [
			'impressions' => $impressionProducts
		];

		$this->googleTagManager->addDataLayerVariable('ecommerce', $ecommerce, 'ecommerce_impressions');
	}

	/**
	 * @param string $blockName
	 * @param string $list
	 * @param string $categoryName
	 * @return array
	 */
	private function getImpressionProducts(string $blockName, string $list, string $categoryName = '')
	{
		$productListBlock = $this->layout->getBlock($blockName);
		if (!$productListBlock) return [];

		$impressionProducts = [];
		$pos = 0;
		foreach ($productListBlock->getLoadedProductCollection() as $product)
		{
			$impressionProducts[] = [
				'id' => $product->getSku(),
				'name' => $product->getName(),
				'price' => $this->priceHelper->getPriceExclTax($product),
				'brand' => $product->getAttributeText('manufacturer'),
				'category' => $categoryName,
				'list' => $list,
				'position' => ++$pos
			];
		}

		return $impressionProducts;
	}

	private function isEnabled()
	{
		return $this->dataLayerEcommerceConfig->isImpressionsEnabled();
	}

}