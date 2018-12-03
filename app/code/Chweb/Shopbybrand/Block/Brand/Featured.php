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

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Chweb\Shopbybrand\Helper\Data as Helper;
use Chweb\Shopbybrand\Model\BrandFactory;

/**
 * Class Featured
 * @package Chweb\Shopbybrand\Block\Brand
 */
class Featured extends Template
{
	/**
	 * Default feature template
	 *
	 * @type string
	 */
	protected $_template = 'brand/featured.phtml';

	/**
	 * @type \Chweb\Shopbybrand\Helper\Data
	 */
	protected $helper;

	/**
	 * @type \Chweb\Shopbybrand\Model\BrandFactory
	 */
	protected $_brandFactory;

	/**
	 * @type
	 */
	protected $_brandCollection;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Chweb\Shopbybrand\Helper\Data $helper
	 * @param \Chweb\Shopbybrand\Model\BrandFactory $brandFactory
	 */
	public function __construct(
		Context $context,
		Helper $helper,
		BrandFactory $brandFactory
	)
	{
		$this->helper        = $helper;
		$this->_brandFactory = $brandFactory;

		parent::__construct($context);
	}

	/**
	 * @return string
	 */
	function includeCssLib()
	{
		$cssFiles = ['Chweb_Core::css/owl.carousel.css', 'Chweb_Core::css/owl.theme.css'];
		$template = '<link rel="stylesheet" type="text/css" media="all" href="%s">' . "\n";
		$result   = '';
		foreach ($cssFiles as $file) {
			$asset = $this->_assetRepo->createAsset($file);
			$result .= sprintf($template, $asset->getUrl());
		}

		return $result;
	}

	/**
	 * @return \Chweb\Shopbybrand\Helper\Data
	 */
	public function helper()
	{
		return $this->helper;
	}

	/**
	 * @return mixed
	 */
	public function getFeatureTitle()
	{
		return $this->helper->getFeatureConfig('name');
	}

	/**
	 * @return bool
	 */
	public function showLabel()
	{
		return $this->helper->getFeatureConfig('display') == \Chweb\Shopbybrand\Model\Config\Source\FeatureDisplay::DISPLAY_LOGO_AND_LABEL;
	}

	/**
	 * @return bool
	 */
	public function showTitle()
	{
		$actionName = $this->getRequest()->getFullActionName();
		if ($actionName != 'mpbrand_index_index') {
			return true;
		}

		return !$this->helper->enableSearch();
	}

	/**
	 * get feature brand
	 * @return mixed
	 */
	public function getFeaturedBrand()
	{
		$featureBrands = [];
		$collection    = $this->_brandFactory->create()
			->getBrandCollection();
		foreach ($collection as $brand) {
			if ($brand->getIsFeatured()) {
				$featureBrands[] = $brand;
			}
		}

		return $featureBrands;
	}
}
