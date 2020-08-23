<?php

namespace Inkl\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template;

class Tag extends Template
{
	protected function _toHtml()
	{
		return '<!-- GTM_PLACEHOLDER -->';
	}
}