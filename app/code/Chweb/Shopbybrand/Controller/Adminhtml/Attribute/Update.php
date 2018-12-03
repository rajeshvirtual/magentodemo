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
namespace Chweb\Shopbybrand\Controller\Adminhtml\Attribute;

/**
 * Class Update
 * @package Chweb\Shopbybrand\Controller\Adminhtml\Attribute
 */
class Update extends \Magento\Backend\App\Action
{
	/**
	 * @type \Magento\Framework\Json\Helper\Data
	 */
	protected $_jsonHelper;

	/**
	 * @type \Chweb\Shopbybrand\Helper\Data
	 */
	protected $_brandHelper;

	/**
	 * @type \Magento\Catalog\Model\Product\Attribute\Repository
	 */
	protected $_productAttributeRepository;

	/**
	 * @type \Chweb\Shopbybrand\Model\BrandFactory
	 */
	protected $_brandFactory;

	/**
	 * @type \Magento\Framework\View\Result\PageFactory
	 */
	protected $_resultPageFactory;

	/**
	 * @type \Magento\Store\Model\StoreManagerInterface
	 */
	protected $_storeManager;

	/**
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\Json\Helper\Data $jsonHelper
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 * @param \Magento\Catalog\Model\Product\Attribute\Repository $productRespository
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
	 * @param \Chweb\Shopbybrand\Helper\Data $brandHelper
	 * @param \Chweb\Shopbybrand\Model\BrandFactory $brandFactory
	 */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\Json\Helper\Data $jsonHelper,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Catalog\Model\Product\Attribute\Repository $productRespository,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Chweb\Shopbybrand\Helper\Data $brandHelper,
		\Chweb\Shopbybrand\Model\BrandFactory $brandFactory
	)
	{
		parent::__construct($context);

		$this->_jsonHelper                 = $jsonHelper;
		$this->_brandHelper                = $brandHelper;
		$this->_productAttributeRepository = $productRespository;
		$this->_brandFactory               = $brandFactory;
		$this->_resultPageFactory          = $resultPageFactory;
		$this->_storeManager               = $storeManager;
	}

	/**
	 * execute
	 */
	public function execute()
	{
		$result        = ['success' => false];
		$optionId      = (int)$this->getRequest()->getParam('id');
		$attributeCode = $this->_brandHelper->getAttributeCode();
		$options       = $this->_productAttributeRepository->get($attributeCode)->getOptions();
		foreach ($options as $option) {
			if ($option->getValue() == $optionId) {
				$result = ['success' => true];
				break;
			}
		}

		if (!$result['success']) {
			$result['message'] = __('Attribute option does not exist.');
		} else {
			$store = $this->getRequest()->getParam('store', 0);
			$brand = $this->_brandFactory->create()->loadByOption($optionId, $store);
			if (!$brand->getUrlKey()) {
				$brand->setUrlKey($this->_brandHelper->formatUrlKey($brand->getDefaultValue()));

				$defaultBlock = $this->_brandHelper->getBrandDetailConfig('default_block', $store);
				if ($defaultBlock) {
					$brand->setStaticBlock($defaultBlock);
				}
			}

			/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
			$resultPage     = $this->_resultPageFactory->create();

			$result['html'] = $resultPage->getLayout()->getBlock('brand.attribute.html')
				->setOptionData($brand->getData())
				->toHtml();
			$result['switcher'] = $resultPage->getLayout()->getBlock('brand.store.switcher')
				->toHtml();
		}

		$this->getResponse()->representJson($this->_jsonHelper->jsonEncode($result));
	}
}
