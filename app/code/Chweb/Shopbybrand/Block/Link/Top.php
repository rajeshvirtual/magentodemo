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
namespace Chweb\Shopbybrand\Block\Link;

/**
 * Class Top
 * @package Chweb\Shopbybrand\Block\Link
 */
class Top extends \Magento\Framework\View\Element\Html\Link
{
	/**
	 * @type \Chweb\Shopbybrand\Helper\Data
	 */
	protected $helper;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Chweb\Shopbybrand\Helper\Data $helper
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Chweb\Shopbybrand\Helper\Data $helper,
		array $data = []
	)
	{
		$this->helper = $helper;

		parent::__construct($context, $data);
	}

	/**
	 * @return string
	 */
	protected function _toHtml()
	{
		if ($this->helper->canShowBrandLink(\Chweb\Shopbybrand\Model\Config\Source\BrandPosition::TOPLINK)) {
			return parent::_toHtml();
		}

		return '';
	}

	/**
	 * @return string
	 */
	public function getHref()
	{
		return $this->helper->getBrandUrl();
	}

	/**
	 * @return \Magento\Framework\Phrase
	 */
	public function getLabel()
	{
		return __($this->helper->getBrandTitle());
	}
}
