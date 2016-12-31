<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model;

use Eadesigndev\Productfeed\Api\Data\FeedInterface;
use Eadesigndev\Productfeed\Model\ResourceModel as FeedResourceModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class Feed extends AbstractModel implements FeedInterface
{
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = [],
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init(FeedResourceModel::class);
    }


    /**
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(FeedInterface::ENTITY_ID);
    }

    public function getIsActive()
    {
        return $this->getData(FeedInterface::IS_ACTIVE);
    }

    public function getName()
    {
        return $this->getData(FeedInterface::NAME);
    }

    public function getFileName()
    {
        return $this->getData(FeedInterface::FILENAME);
    }

    public function getUrl()
    {
        return $this->getData(FeedInterface::URL);
    }

    public function getDescription()
    {
        return $this->getData(FeedInterface::DESCRIPTION);
    }

    public function getDelimiter()
    {
        return $this->getData(FeedInterface::DELIMITER);
    }

    public function getStockStatus()
    {
        return $this->getData(FeedInterface::STOCK_STATUS);
    }

    public function getStatus()
    {
        return $this->getData(FeedInterface::STATUS);
    }

    public function getVisibility()
    {
        return $this->getData(FeedInterface::VISIBILITY);
    }

    public function getCategories()
    {
        return $this->getData(FeedInterface::CATEGORIES);
    }

    public function getFields()
    {
        return $this->getData(FeedInterface::FIELDS);
    }

    public function getCreationTime()
    {
        return $this->getData(FeedInterface::CREATION_TIME);
    }

    public function getUpdateTime()
    {
        return $this->getData(FeedInterface::UPDATE_TIME);
    }

    public function getStoreId()
    {
        return $this->getData(FeedInterface::STORE_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setEntityId($id)
    {
        return $this->setData(FeedInterface::ENTITY_ID, $id);
    }

    public function setIsActive($isActive)
    {
        return $this->setData(FeedInterface::IS_ACTIVE, $isActive);
    }

    public function setName($name)
    {
        return $this->setData(FeedInterface::NAME, $name);
    }

    public function setFileName($fileName)
    {
        return $this->setData(FeedInterface::FILENAME, $fileName);
    }

    public function setUrl($url)
    {
        return $this->setData(FeedInterface::URL, $url);
    }

    public function setDescription($description)
    {
        return $this->setData(FeedInterface::DESCRIPTION, $description);
    }

    public function setDelimiter($delimiter)
    {
        return $this->setData(FeedInterface::DELIMITER, $delimiter);
    }

    public function setStockStatus($stockStatus)
    {
        return $this->setData(FeedInterface::STOCK_STATUS, $stockStatus);
    }

    public function setStatus($status)
    {
        return $this->setData(FeedInterface::STATUS, $status);
    }

    public function setVisibility($visibility)
    {
        return $this->setData(FeedInterface::VISIBILITY, $visibility);
    }

    public function setCategories($categories)
    {
        return $this->setData(FeedInterface::CATEGORIES, $categories);
    }

    public function setFields($fields)
    {
        return $this->setData(FeedInterface::FIELDS, $fields);
    }

    public function setCreationTime($creationTime)
    {
        return $this->setData(FeedInterface::CREATION_TIME, $creationTime);
    }

    public function setUpdateTime($updateTime)
    {
        return $this->setData(FeedInterface::UPDATE_TIME, $updateTime);
    }

    public function setStoreId($storeId)
    {
        return $this->setData(FeedInterface::STORE_ID, $storeId);
    }
}