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
namespace Chweb\Shopbybrand\Model\ResourceModel\Brand;

/**
 * Class Collection
 * @package Chweb\Shopbybrand\Model\ResourceModel\Brand
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * ID Field Name
	 *
	 * @var string
	 */
	protected $_idFieldName = 'brand_id';

	/**
	 * Event prefix
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'Chweb_shopbybrand_brand_collection';

	/**
	 * Event object
	 *
	 * @var string
	 */
	protected $_eventObject = 'brand_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Chweb\Shopbybrand\Model\Brand', 'Chweb\Shopbybrand\Model\ResourceModel\Brand');
	}

	/**
	 * Get SQL for get record count.
	 * Extra GROUP BY strip added.
	 *
	 * @return \Magento\Framework\DB\Select
	 */
	public function getSelectCountSql()
	{
		$countSelect = parent::getSelectCountSql();
		$countSelect->reset(\Zend_Db_Select::GROUP);

		return $countSelect;
	}

	/**
	 * @param string $valueField
	 * @param string $labelField
	 * @param array $additional
	 * @return array
	 */
	protected function _toOptionArray($valueField = 'brand_id', $labelField = 'name', $additional = [])
	{
		return parent::_toOptionArray($valueField, $labelField, $additional);
	}
}
