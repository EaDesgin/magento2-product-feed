<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Eadesigndev\Productfeed\Controller\Adminhtml\Generate;

use Eadesigndev\Productfeed\Api\FeedProductRepositoryInterface;
use Eadesigndev\Productfeed\Model\ResourceModel\ProductURLLink;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    private $feedProductRepositoryInterface;

    private $searchCriteria;

    private $filter;

    private $filterGroup;

    public function __construct(
        Context $context,
        Builder $productBuilder,
        PageFactory $resultPageFactory,
        FeedProductRepositoryInterface $feedProductRepositoryInterface,
        Filter $filter,
        FilterGroup $filterGroup,
        SearchCriteriaInterface $searchCriteria
    )
    {
        parent::__construct($context, $productBuilder);
        $this->resultPageFactory = $resultPageFactory;
        $this->feedProductRepositoryInterface = $feedProductRepositoryInterface;
        $this->filter = $filter;
        $this->filterGroup = $filterGroup;
        $this->searchCriteria = $searchCriteria;
    }

    /**
     * Product list page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public
    function execute()
    {

        $filter = $this->filter;
        $filter->setData('field', 'sku');
        $filter->setData('value', '%%');
        $filter->setData('condition_type', 'like');

        $filter1 = $this->filter;
        $filter1->setData('field', 'category_id');
        $filter1->setData('value', '2');
        $filter1->setData('condition_type', 'eq');

        $filterGroup = $this->filterGroup->setFilters([$filter1]);

        $searchCriteria = $this->searchCriteria->setFilterGroups([$filterGroup]);

        $productList = $this->feedProductRepositoryInterface->getList($searchCriteria);

        echo '<pre>';
        print_r($productList->getTotalCount());
        exit();


        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Catalog::product_feed');
        $resultPage->getConfig()->getTitle()->prepend(__('Feed'));
        return $resultPage;
    }
}
