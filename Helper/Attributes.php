<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Helper;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface as ProductAttributeRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Attributes extends AbstractHelper
{

    /**
     * @var ProductAttributeRepository
     */
    private $productAttributeRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Attributes constructor.
     * @param Context $context
     * @param ProductAttributeRepository $productAttributeRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        ProductAttributeRepository $productAttributeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->productAttributeRepository = $productAttributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductAttributeInterface[]
     */
    public function collection()
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(ProductAttributeInterface::IS_VISIBLE, 1)
            ->create();

        return $this->productAttributeRepository->getList($searchCriteria)->getItems();
    }
}