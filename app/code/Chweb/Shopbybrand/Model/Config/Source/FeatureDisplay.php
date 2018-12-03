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
 * Class FeatureDisplay
 * @package Chweb\Shopbybrand\Model\Config\Source
 */
class FeatureDisplay implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * Display only logo
	 */
	const DISPLAY_LOGO = 0;

	/**
	 * Display logo and label
	 */
	const DISPLAY_LOGO_AND_LABEL = 1;

	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			[
				'label' => __('Logo Only'),
				'value' => self::DISPLAY_LOGO
			],
			[
				'label' => __('Logo and Label'),
				'value' => self::DISPLAY_LOGO_AND_LABEL
			]
		];
	}
}
