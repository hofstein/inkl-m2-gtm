<?php

namespace Inkl\GoogleTagManager\Helper;

use Magento\Framework\DataObject;
use Magento\Tax\Model\Calculation as TaxCalculation;

class TaxHelper
{
	/** @var array */
	private $taxPercents = [];
	/** @var TaxCalculation */
	private $taxCalculation;

	/**
	 * @param TaxCalculation $taxCalculation
	 */
	public function __construct(TaxCalculation $taxCalculation)
	{
		$this->taxCalculation = $taxCalculation;
	}

	public function getTaxPercent($taxClassId)
	{
		if (isset($this->taxPercents[$taxClassId]))
		{
			return $this->taxPercents[$taxClassId];
		}

		$request = new DataObject(['product_class_id' => $taxClassId]);
		
		return $this->taxPercents[$taxClassId] = $this->taxCalculation->getStoreRate($request);
	}

}