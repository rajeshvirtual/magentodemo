<?php
/**
 * Chweb
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Chweb.com license that is
 * available through the world-wide-web at this URL:
 * https://www.Chweb.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Chweb
 * @package     Chweb_Shopbybrand
 * @copyright   Copyright (c) 2016 Chweb (http://www.Chweb.com/)
 * @license     https://www.Chweb.com/LICENSE.txt
 */
namespace Chweb\Shopbybrand\Model\Config\Source;

/**
 * Class BrandPosition
 * @package Chweb\Shopbybrand\Model\Config\Source
 */
class BrandPosition implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * Show on Toplink
	 */
	const TOPLINK = 0;

	/**
	 * Show on Footerlink
	 */
	const FOOTERLINK = 1;

	/**
	 * Show on Menubar
	 */
	const CATEGORY = 2;

	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			[
				'label' => __('-- Please select --'),
				'value' => '',
			],
			[
				'label' => __('Toplink'),
				'value' => self::TOPLINK,
			],
			[
				'label' => __('Footerlink'),
				'value' => self::FOOTERLINK,
			],
			[
				'label' => __('Category'),
				'value' => self::CATEGORY,
			],
		];
	}
}
