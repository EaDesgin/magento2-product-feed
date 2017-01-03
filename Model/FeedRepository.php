<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model;

use Eadesigndev\Productfeed\Api\Data\FeedInterface;
use Eadesigndev\Productfeed\Api\FeedRepositoryInterface;
use Eadesigndev\Productfeed\Model\ResourceModel\Feed as FeedResourceModel;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class FeedRepository implements FeedRepositoryInterface
{

    private $instances = [];

    private $feedResourceModel;

    private $feedFactory;

    public function __construct(FeedResourceModel $feedResourceModel, FeedFactory $feedFactory)
    {
        $this->feedResourceModel = $feedResourceModel;
        $this->feedFactory = $feedFactory;
    }

    public function save(FeedInterface $feed)
    {
        /** @var \Eadesigndev\Productfeed\Api\Data\FeedInterface|\Magento\Framework\Model\AbstractModel $feed */
        try {
            $this->feedResourceModel->save($feed);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the feed: %1',
                $exception->getMessage()
            ));
        }

        return $feed;
    }

    public function getById($feedId)
    {
        if (!isset($this->instances[$feedId])) {
            /** @var \Eadesigndev\Productfeed\Api\Data\FeedInterface|\Magento\Framework\Model\AbstractModel $feed */
            $feed = $this->feedFactory->create();
            $this->feedResourceModel->load($feed, $feedId);

            if (!$feed->getId()) {
                throw new NoSuchEntityException(__('Requested feed doesn\'t exist'));
            }

            $this->instances[$feedId] = $feed;
        }

        return $this->instances[$feedId];
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    public function deleteById($feedId)
    {
        $feed = $this->getById($feedId);
        return $this->delete($feed);
    }

    public function delete(FeedInterface $feed)
    {
        /** @var \Eadesigndev\Productfeed\Api\Data\FeedInterface|\Magento\Framework\Model\AbstractModel $feed */
        $id = $feed->getId();
        try {
            unset($this->instances[$id]);
            $this->feedResourceModel->delete($feed);

        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove feed %1', $id)
            );
        }

        unset($this->instances[$id]);

        return true;
    }

}