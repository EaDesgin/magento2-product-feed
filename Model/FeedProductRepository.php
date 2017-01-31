<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model;

use Eadesigndev\Productfeed\Api\FeedProductRepositoryInterface;
use Eadesigndev\Productfeed\Model\ResourceModel\ProductURLLink;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Store\Model\StoreManagerInterface;

class FeedProductRepository implements FeedProductRepositoryInterface
{

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var
     * todo to move to another model
     */
    private $categoryCollection;

    private $categoriesArray = [];

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    private $joinProcessor;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $metadataService;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    private $productURLLink;

    public function __construct(
        CategoryCollectionFactory $categoryCollectionFactory,
        CollectionFactory $collectionFactory,
        JoinProcessorInterface $joinProcessor,
        ProductAttributeRepositoryInterface $metadataServiceInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductSearchResultsInterfaceFactory $searchResultsFactory,
        StoreManagerInterface $storeManager,
        ProductURLLink $productURLLink
    )
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->joinProcessor = $joinProcessor;
        $this->metadataService = $metadataServiceInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->storeManager = $storeManager;
        $this->productURLLink = $productURLLink;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->joinProcessor->process($collection);

        foreach ($this->metadataService->getList($this->searchCriteriaBuilder->create())->getItems() as $metadata) {
            $collection->addAttributeToSelect($metadata->getAttributeCode());
        }

//        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
//        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
//        $collection->joinAttribute('image', 'catalog_product/image', 'entity_id', null, 'inner');
//        $collection->joinAttribute('thumbnail', 'catalog_product/thumbnail', 'entity_id', null, 'inner');
//        $collection->joinAttribute('small_image', 'catalog_product/small_image', 'entity_id', null, 'inner');


        //Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }

        $this->addOrderToCollection($searchCriteria, $collection);

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        echo '<pre>';

        //todo get this from another model
        $this->addCategoryCollection();

        foreach ($collection as $item) {
            $catPath = $this->processCategories($item);
            echo '<pre>';
            print_r($catPath);
        }

        exit();
        $this->collection = $collection;

        $this->productURLLink->joinToCollection($collection);

        $this->addPriceToCollection();

        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;

    }

    /**
     * Add price filter to collection
     */
    private function addPriceToCollection()
    {
        $this->collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return void
     */
    protected function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        Collection $collection
    )
    {
        $fields = [];
        $categoryFilter = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $conditionType = $filter->getConditionType() ? $filter->getConditionType() : 'eq';

            if ($filter->getField() == 'category_id') {
                $categoryFilter[$conditionType][] = $filter->getValue();
                continue;
            }
            $fields[] = ['attribute' => $filter->getField(), $conditionType => $filter->getValue()];
        }

        if ($categoryFilter) {
            $collection->addCategoriesFilter($categoryFilter);
        }

        if ($fields) {
            $collection->addFieldToFilter($fields);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param $collection
     * @return $collection \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    private function addOrderToCollection(SearchCriteriaInterface $searchCriteria, $collection)
    {
        /** @var SortOrderOrder $sortOrder */
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $field = $sortOrder->getField();
            $collection->addOrder(
                $field,
                ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
            );
        }

        return $collection;
    }

    /**
     * @param $item
     * todo temporary to move to another model
     */
    public function processCategories($item)
    {

        $categoriesIds = $item->getCategoryIds();
        //todo refactor here - strange code
        $this->processCategoryCollection();


        if (!empty($categoriesIds)) {
            $cat = array_intersect_key($this->categoriesArray, array_flip($categoriesIds));
        }

//        print_r($categoriesIds);
//        print_r(array_keys($this->categoriesArray));
//        print_r(array_keys($cat));

        $catLevel = [];
        foreach ($cat as $c) {
            $catLevel[$c->getId()] = $c;
        }

//        echo '<pre>';
//        print_r($catLevel);
//        return $catLevel;
//        exit();


        //todo remove the validation before happens
        if (!empty($catLevel)) {
            $deepestCategory = max($catLevel);

            $categoryPathByIds = explode('/', $deepestCategory->getPath());

            $arrayNames = [];
            foreach ($categoryPathByIds as $categoryPathById) {
                $arrayNames [$categoryPathById] = $this->categoriesArray[$categoryPathById]->getName();
            }

            $delimiter = ' > ';

            $finalStringCategoryes = implode($delimiter, $arrayNames);
            return $finalStringCategoryes;

//            print_r($finalStringCategoryes);
        }


    }

    public function processCategoryCollection()
    {
        $categoryCollection = $this->categoryCollection;

        foreach ($categoryCollection as $item) {
            $this->categoriesArray[$item->getId()] = $item;
        }

        return $this->categoriesArray;

//        print_r($item->getData());
//        print_r(array_keys($categoryCollection));
//        echo get_class($categoryCollection);
//        print_r(array_keys($final));
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     * todo move the another model
     */
    private function addCategoryCollection()
    {

        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*');
        $this->categoryCollection = $categoryCollection;

        return $this->categoryCollection;
    }

}