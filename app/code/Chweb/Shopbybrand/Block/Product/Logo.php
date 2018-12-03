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
namespace Chweb\Shopbybrand\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Chweb\Shopbybrand\Helper\Data as Helper;
use Chweb\Shopbybrand\Model\BrandFactory;

/**
 * Class Logo
 * @package Chweb\Shopbybrand\Block\Product
 */
class Logo extends Template
{
	/** @var \Chweb\Shopbybrand\Helper\Data */
	protected $helper;

	/** @var \Magento\Framework\Registry */
	protected $_registry;

	/** @var \Chweb\Shopbybrand\Model\BrandFactory */
	protected $_brandFactory;

	/** @var \Chweb\Shopbybrand\Model\Brand */
	protected $_brand;

	/**
	 * Logo constructor.
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Chweb\Shopbybrand\Helper\Data $helper
	 * @param \Magento\Framework\Registry $registry
	 * @param \Chweb\Shopbybrand\Model\BrandFactory $brandFactory
	 */
	public function __construct(
		Context $context,
		Helper $helper,
		\Magento\Framework\Registry $registry,
		BrandFactory $brandFactory
	)
	{
		$this->helper        = $helper;
		$this->_registry     = $registry;
		$this->_brandFactory = $brandFactory;

		parent::__construct($context);
	}

	/**
	 * Get product brand
	 *
	 * @return null | Brand
	 */
	public function getProductBrand()
	{
		if (!$this->helper->isEnabled() || !$this->helper->getGeneralConfig('show_logo')) {
			return null;
		}

		$product = $this->_registry->registry('current_product');
		if (($product instanceof \Magento\Catalog\Model\Product) && $product->getId()) {
			$attCode = $this->helper->getAttributeCode();
			if ($optionId = $product->getData($attCode)) {
				return $this->_brandFactory->create()->loadByOption($optionId);
			}
		}

		return null;
	}

	/**
	 * @return \Chweb\Shopbybrand\Helper\Data
	 */
	public function helper()
	{
		return $this->helper;
	}
}
