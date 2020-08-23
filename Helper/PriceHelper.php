<?php

namespace Inkl\GoogleTagManager\Helper;

use Magento\Catalog\Api\Data\ProductInterface;

class PriceHelper
{
	/** @var TaxHelper */
	private $taxHelper;

	/**
	 * @param TaxHelper $taxHelper
	 */
	public function __construct(TaxHelper $taxHelper)
	{
		$this->taxHelper = $taxHelper;
	}

	public function getPriceExclTax(ProductInterface $product)
	{
		$taxFactor = ($this->taxHelper->getTaxPercent($product->getTaxClassId()) / 100) + 1;
		return round(($product->getFinalPrice() / $taxFactor), 2);
	}

}