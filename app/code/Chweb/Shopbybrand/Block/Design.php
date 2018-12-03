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
namespace Chweb\Shopbybrand\Block;

use Chweb\Shopbybrand\Helper\Data as Config;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Design
 * @package Chweb\Shopbybrand\Block
 */
class Design extends Template
{
	/**
	 * @var Config
	 */
	protected $_helperConfig;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Chweb\Shopbybrand\Helper\Data $helperConfig
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		Config $helperConfig,
		array $data = []
	)
	{

		parent::__construct($context, $data);

		$this->_helperConfig = $helperConfig;
	}

	/**
	 * @return \Chweb\Shopbybrand\Helper\Data
	 */
	public function helper()
	{
		return $this->_helperConfig;
	}

	/**
	 * @return mixed
	 */
	public function getCustomCss()
	{
		return $this->_helperConfig->getBrandConfig('custom_css');
	}
}
