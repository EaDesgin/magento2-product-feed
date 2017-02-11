<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CategoryLink
 * @package Eadesigndev\Productfeed\Model\ResourceModel
 * Adding the category system to the application to get he category product utl link and deepest category.
 * @deprecated
 */

class CategoryResource extends AbstractDb
{

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    private $categoryCollection;

    /**
     * @var array
     */
    private $categoriesArray = [];

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * CategoryResource constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        CategoryCollectionFactory $categoryCollectionFactory,
        $connectionName = null
    )
    {
        $this->storeManager = $storeManager;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->addCategoryCollection();
        parent::__construct($context, $connectionName);
    }

    /**
     * Getting in the database zone!
     */
    protected function _construct()
    {
        $this->_init('catalog_category_entity', 'entity_id');
    }

    /**
     * @param $item
     * @return string
     */
    public function processCategories($item)
    {

        $categoriesIds = $item->getCategoryIds();

        //todo refactor here - strange code
        $this->processCategoryCollection();


        if (!empty($categoriesIds)) {
            $cat = array_intersect_key($this->categoriesArray, array_flip($categoriesIds));
        }

        $catLevel = [];
        foreach ($cat as $c) {
            $catLevel[$c->getId()] = $c;
        }

        //todo remove the validation before happens

        if (!empty($catLevel)) {
            $deepestCategory = max($catLevel);

            $categoryPathByIds = explode('/', $deepestCategory->getPath());

            $arrayNames = [];
            foreach ($categoryPathByIds as $categoryPathById) {
                $arrayNames [$categoryPathById] = $this->categoriesArray[$categoryPathById]->getName();
            }

            $delimiter = ' > ';

            $finalStringCategories = implode($delimiter, $arrayNames);

            return $finalStringCategories;
        }

    }

    /**
     * @return array
     */
    public function processCategoryCollection()
    {

        $categoryCollection = $this->categoryCollection;

        foreach ($categoryCollection as $item) {
            $this->categoriesArray[$item->getId()] = $item;
        }

        return $this->categoriesArray;

    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    public function addCategoryCollection()
    {

        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*');
        $this->categoryCollection = $categoryCollection;

        return $this->categoryCollection;
    }

}