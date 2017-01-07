<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eadesigndev\Productfeed\Api\Data\FeedInterface;

interface FeedProductRepositoryInterface
{

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}