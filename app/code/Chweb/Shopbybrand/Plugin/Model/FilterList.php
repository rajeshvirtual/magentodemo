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

namespace Chweb\Shopbybrand\Plugin\Model;

/**
 * Class FilterList
 */
class FilterList
{

	/** @var \Chweb\Shopbybrand\Helper\Data  */
	protected $helper;

	/** @var \Magento\Framework\App\RequestInterface  */
	protected $request;

	/** @var \Magento\Framework\ObjectManagerInterface  */
	protected $objectManager;

	/** @var  filter */
	protected $_filter;

	/**
	 * FilterList constructor.
	 * @param \Magento\Framework\ObjectManagerInterface $objectManager
	 * @param \Magento\Framework\App\RequestInterface $request
	 * @param \Chweb\Shopbybrand\Helper\Data $helper
	 */
	public function __construct(
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Framework\App\RequestInterface $request,
		\Chweb\Shopbybrand\Helper\Data $helper
	)
	{
		$this->objectManager      = $objectManager;
		$this->helper             = $helper;
		$this->request            = $request;
	}

	/**
	 * @param \Magento\Catalog\Model\Layer\FilterList $subject
	 * @param $result
	 * @return mixed
	 */
	public function afterGetFilters(\Magento\Catalog\Model\Layer\FilterList $subject, $result)
	{
		if ($this->request->getFullActionName() != 'mpbrand_index_view') {
			return $result;
		}

		$brandAttCode = $this->helper->getAttributeCode();
		foreach ($result as $key => $filter) {
			if ($filter->getRequestVar() == $brandAttCode) {
				if(!$this->_filter){
					$this->_filter = $this->objectManager->create(
						'Chweb\Shopbybrand\Model\Layer\Filter\Attribute',
						['data' => ['attribute_model' => $filter->getAttributeModel()], 'layer' => $filter->getLayer()]
					);
				}
				$result[$key] = $this->_filter;
				break;
			}
		}

		return $result;
	}
}
