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
 * Class Search
 * @package Chweb\Shopbybrand\Block\Brand
 */
class Search extends \Chweb\Shopbybrand\Block\Brand
{
	/**
	 * @return string
	 */
	public function getSearchData()
	{
		$searchData      = array();
		foreach ($this->getCollection() as $brand) {
			$searchData[] = array(
				'value'    => $brand->getValue(),
				'desc'     => $this->helper->getBrandDescription($brand, true),
				'image'    => $this->helper->getBrandImageUrl($brand),
				'brandUrl' => $this->helper->getBrandUrl($brand)
			);
		}

		return json_encode($searchData);
	}

	/**
	 * @return mixed
	 */
	public function getMaxQueryResult()
	{
		return $this->helper->getSearchConfig('max_query_results') ?: 10;
	}

	/**
	 * @return mixed
	 */
	public function getMinSearchChar()
	{
		return $this->helper->getSearchConfig('min_search_chars') ?: 1;
	}

	/**
	 * @return mixed
	 */
	public function isVisibleImage()
	{
		return $this->helper->getSearchConfig('visible_images');
	}
}
