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
namespace Chweb\Shopbybrand\Model\Import\Behavior;

/**
 * Class Brand
 * @package Chweb\Shopbybrand\Model\Import\Behavior
 */
class Brand extends \Magento\ImportExport\Model\Source\Import\AbstractBehavior
{
	/**
	 * {@inheritdoc}
	 */
	public function toArray()
	{
		return [
			\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND  => __('Add/Update'),
			\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE  => __('Delete')
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCode()
	{
		return 'brand';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getNotes($entityCode)
	{
		$messages = ['Chweb_brand' => [
			\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND  => __("Note: Please select the brand attribute in Chweb_Shopbybrand configuration first."),
			\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE  => __("Note: Please select the brand attribute in Chweb_Shopbybrand configuration first."),
		]];

		return isset($messages[$entityCode]) ? $messages[$entityCode] : [];
	}
}
