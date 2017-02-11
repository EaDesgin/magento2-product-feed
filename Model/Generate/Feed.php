<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model\Generate;

use Eadesigndev\Productfeed\Api\FeedProductRepositoryInterface;
use Eadesigndev\Productfeed\Model\ResourceModel\CategoryResource;
use Eadesigndev\Productfeed\Helper\CsvFeed;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class Feed
{

    /**
     * @var FeedProductRepositoryInterface
     */
    private $feedProductRepositoryInterface;

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var FilterGroup
     */
    private $filterGroup;

    /**
     * @var CategoryResource
     */
    private $categoryResource;

    /**
     * Array of products
     * @var array
     */
    private $items = [];

    /**
     * Array or products data
     * @var array
     */
    private $data = [];

    /**
     * @var CsvFeed
     */
    private $csvFeed;

    /**
     * Feed constructor.
     * @param FeedProductRepositoryInterface $feedProductRepositoryInterface
     * @param Filter $filter
     * @param FilterGroup $filterGroup
     * @param SearchCriteriaInterface $searchCriteria
     * @param CategoryResource $categoryResource
     * @param CsvFeed $csvFeed
     */
    public function __construct(
        FeedProductRepositoryInterface $feedProductRepositoryInterface,
        Filter $filter,
        FilterGroup $filterGroup,
        SearchCriteriaInterface $searchCriteria,
        CategoryResource $categoryResource,
        CsvFeed $csvFeed
    )
    {
        $this->feedProductRepositoryInterface = $feedProductRepositoryInterface;
        $this->filter = $filter;
        $this->filterGroup = $filterGroup;
        $this->searchCriteria = $searchCriteria;
        $this->categoryResource = $categoryResource;
        $this->csvFeed = $csvFeed;
    }

    /**
     * Generate the feed data not the actual file.
     */
    public function generate()
    {
        $filter = $this->filter;
        $filter->setData('field', 'sku');
        $filter->setData('value', '%%');
        $filter->setData('condition_type', 'like');

        $filterGroup = $this->filterGroup->setFilters([$filter]);

        $searchCriteria = $this->searchCriteria->setFilterGroups([$filterGroup]);

        $productList = $this->feedProductRepositoryInterface->getList($searchCriteria);

        $items = $productList->getItems();

        $this->processItems($items);

        $this->csvFeed->saveFile('default.csv', $this->data);

        exit();

    }

    /**
     * The products to be processed
     * @param array $items
     * @return $this
     */
    protected function processItems($items = [])
    {
        $this->items = $items;
        $this->addCategoryChildren();

        return $this;

    }

    /**
     * Add the category tree to the items
     * @return void
     */
    private function addCategoryChildren()
    {

        if (!empty($this->items)) {
            $items = $this->items;
            $this->items = [];
            foreach ($items as $item) {
                $catPath = $this->categoryResource->processCategories($item);
                /** @var $item  Product */
                $item->setData('category_tree', $catPath);

                $this->items[] = $item;
                $data = $item->getData();
                $this->data [] = $this->sanitize($data);
            }
        }

    }

    private function sanitize($lines)
    {
        foreach ($lines as $line => $value) {
            if (is_object($value) || is_array($value)) {
                continue;
            }

            $data[$line] = $value;
        }

        return $data;

    }

}