<?php

namespace Inkl\GoogleTagManager\Model\DataLayer\General;

class PageTypeEx extends PageType
{

	public function handle()
	{
		if (!$this->isEnabled())
		{
			return;
		}

		$pageTypeEx = $this->determine();
		if ($pageTypeEx)
		{
			$this->googleTagManager->addDataLayerVariable('pageTypeEx', $pageTypeEx, 'page_type_ex');
		}
	}

	protected function determine()
	{
		if ($this->routeHelper->isCheckout()) return 'checkout';

		return parent::determine();
	}

}
