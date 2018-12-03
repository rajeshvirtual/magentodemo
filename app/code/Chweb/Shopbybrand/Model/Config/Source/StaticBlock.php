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

use Magento\Cms\Model\BlockFactory;

/**
 * Class StaticBlock
 * @package Chweb\Shopbybrand\Model\Config\Source
 */
class StaticBlock implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * @type \Magento\Cms\Model\BlockFactory
	 */
	protected $_blockFactory;

	/**
	 * @param \Magento\Cms\Model\BlockFactory $blockFactory
	 */
	public function __construct(BlockFactory $blockFactory)
	{
		$this->_blockFactory = $blockFactory;
	}

	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		$options = [];
		foreach ($this->getOptionArray() as $identifier => $title) {
			$options[] = [
				'label' => $title,
				'value' => $identifier
			];
		}

		return $options;
	}

	/**
	 * @return array
	 */
	public function getOptionArray()
	{
		$resultBlocks    = ['' => __('-- Please Select --')];
		$blockCollection = $this->_blockFactory->create()->getCollection();
		foreach ($blockCollection as $block) {
			$resultBlocks[$block->getData('identifier')] = $block->getData('title');
		}

		return $resultBlocks;
	}
}
