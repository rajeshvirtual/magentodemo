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
namespace Chweb\Shopbybrand\Block\Brand;

/**
 * Class BrandList
 * @package Chweb\Shopbybrand\Block\Brand
 */
class BrandList extends \Chweb\Shopbybrand\Block\Brand
{
	/**
	 * @type string
	 */
	protected $_char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	/**
	 * Get alphabet list array
	 *
	 * @return array
	 */
	public function getAlphabet()
	{
		$alphaBet    = [];
		$activeChars = [];

		foreach ($this->getCollection() as $brand) {
			$name = $brand->getValue();
			if (is_string($name) && strlen($name) > 0) {
				$firstChar = is_numeric($name[0]) ? '0-9' : strtoupper($name[0]);
				if (!in_array($firstChar, $activeChars)) {
					$activeChars[] = $firstChar;
				}
			}
		}

		for ($i = 0; $i < strlen($this->_char); $i++) {
			$alphaBet[] = [
				'char'   => $this->_char[$i],
				'active' => in_array($this->_char[$i], $activeChars)
			];
		}
		$alphaBet[] = [
			'char'   => 'num',
			'label'  => '0-9',
			'active' => in_array('0-9', $activeChars)
		];

		return $alphaBet;
	}

	/**
	 * Get class for mixitup filter
	 *
	 * @param $brand
	 * @return string
	 */
	public function getFilterClass($brand)
	{
		$firstChar = $brand->getValue()[0];

		return is_numeric($firstChar) ? 'num' : strtoupper($firstChar);
	}

	/**
	 * Is show description below Brand name
	 *
	 * @return mixed
	 */
	public function showDescription()
	{
		return $this->helper->getBrandConfig('show_description');
	}

	/**
	 * Is show Label
	 *
	 * @return bool
	 */
	public function showLabel()
	{
		return $this->helper->getBrandConfig('display') == \Chweb\Shopbybrand\Model\Config\Source\FeatureDisplay::DISPLAY_LOGO_AND_LABEL;
	}
}
