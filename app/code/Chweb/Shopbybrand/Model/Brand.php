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
namespace Chweb\Shopbybrand\Model;

use Magento\Eav\Model\Config;
use Chweb\Shopbybrand\Helper\Data as Helper;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;

/**
 * Class Brand
 * @package Chweb\Shopbybrand\Model
 */
class Brand extends \Magento\Framework\Model\AbstractModel
{
	/**
	 * Cache tag
	 *
	 * @var string
	 */
	const CACHE_TAG = 'Chweb_shopbybrand_brand';

	/**
	 * Cache tag
	 *
	 * @var string
	 */
	protected $_cacheTag = 'Chweb_shopbybrand_brand';

	/**
	 * Event prefix
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'Chweb_shopbybrand_brand';

	/**
	 * @type \Magento\Eav\Model\Config
	 */
	protected $eavConfig;

	/**
	 * @type \Magento\Store\Model\StoreManagerInterface
	 */
	protected $_storeManager;

	/**
	 * @type \Chweb\Shopbybrand\Helper\Data
	 */
	protected $helper;

	/**
	 * @type \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory
	 */
	protected $_attrOptionCollectionFactory;

	/**
	 * Brand constructor.
	 * @param \Magento\Framework\Model\Context $context
	 * @param \Magento\Framework\Registry $registry
	 * @param \Magento\Eav\Model\Config $eavConfig
	 * @param \Chweb\Shopbybrand\Helper\Data $helper
	 * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
	 * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		Config $eavConfig,
		Helper $helper,
		CollectionFactory $attrOptionCollectionFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
		array $data = []
	)
	{
		$this->eavConfig                    = $eavConfig;
		$this->helper                       = $helper;
		$this->_storeManager                = $storeManager;
		$this->_attrOptionCollectionFactory = $attrOptionCollectionFactory;

		parent::__construct($context, $registry, $resource, $resourceCollection, $data);
	}

	/**
	 * Initialize resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Chweb\Shopbybrand\Model\ResourceModel\Brand');
	}

	/**
	 * Get identities
	 *
	 * @return array
	 */
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	/**
	 * @param null $storeId
	 * @param array $conditions
	 * @return mixed
	 */
	public function getBrandCollection($storeId = null, $conditions = [])
	{
		$storeId    = is_null($storeId) ? $this->_storeManager->getStore()->getId() : $storeId;
		$attribute  = $this->eavConfig->getAttribute('catalog_product', $this->helper->getAttributeCode());
		$collection = $this->_attrOptionCollectionFactory->create()
			->setPositionOrder('asc')
			->setAttributeFilter($attribute->getId())
			->setStoreFilter($storeId);

		$connection = $collection->getConnection();
		$storeIdCondition = 0;
		if ($storeId) {
			$storeIdCondition = $connection->select()
				->from(['ab' => $collection->getTable('Chweb_brand')], 'MAX(ab.store_id)')
				->where('ab.option_id = br.option_id AND ab.store_id IN (0, ' . $storeId . ')');
		}

		$collection->getSelect()
			->joinLeft(
				['br' => $collection->getTable('Chweb_brand')],
				"main_table.option_id = br.option_id AND br.store_id = (" . $storeIdCondition . ')' . (is_string($conditions) ? $conditions : ''),
				[
					'brand_id' => new \Zend_Db_Expr($connection->getCheckSql('br.store_id = ' . $storeId, 'br.brand_id', 'NULL')),
					'store_id' => new \Zend_Db_Expr($storeId),
					'page_title',
					'url_key',
					'short_description',
					'description',
					'is_featured',
					'static_block',
					'meta_title',
					'meta_keywords',
					'meta_description',
					'image'
				]
			)
			->joinLeft(
				['sw' => $collection->getTable('eav_attribute_option_swatch')],
				"main_table.option_id = sw.option_id",
				['swatch_type' => 'type', 'swatch_value' => 'value']
			)
			->group('option_id');

		if(is_array($conditions)) {
			foreach ($conditions as $field => $condition) {
				$collection->addFieldToFilter($field, $condition);
			}
		}

		return $collection;
	}

	/**
	 * @param $optionId
	 * @param null $store
	 * @return mixed
	 */
	public function loadByOption($optionId, $store = null)
	{
		$collection = $this->getBrandCollection($store, ['main_table.option_id' => $optionId]);

		return $collection->getFirstItem();
	}
}
