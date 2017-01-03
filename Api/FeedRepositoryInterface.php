<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Eadesigndev\Productfeed\Api\Data\FeedInterface;

interface FeedRepositoryInterface
{
    /**
     * Save feed.
     *
     * @param FeedInterface $feed
     * @return FeedInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(FeedInterface $feed);

    /**
     * Retrieve Author.
     *
     * @param int $feedId
     * @return FeedInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($feedId);

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete feed.
     *
     * @param FeedInterface $feed
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(FeedInterface $feed);

    /**
     * Delete feed by ID.
     *
     * @param int $feedId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($feedId);

}