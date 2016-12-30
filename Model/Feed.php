<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model;

use Eadesigndev\Productfeed\Api\Data\FeedInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource ;
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

    public function getEntityId(){}
    public function getIsActive(){}
    public function getName(){}
    public function getFileName(){}
    public function getUrl(){}
    public function getDescription(){}
    public function getDelimiter(){}
    public function getStockStatus(){}
    public function getStatus(){}
    public function getVisibility(){}
    public function getCategories(){}
    public function getFields(){}
    public function getCreationTime(){}
    public function getUpdateTime(){}
    public function getStoreId(){}

    public function setEntityId($id){}
    public function setIsActive($isActive){}
    public function setName($name){}
    public function setFileName($fileName){}
    public function setUrl($url){}
    public function setDescription($description){}
    public function setDelimiter($delimiter){}
    public function setStockStatus($stickStatus){}
    public function setStatus($status){}
    public function setVisibility($visibility){}
    public function setCategories($categories){}
    public function setFields($fields){}
    public function setCreationTime($creationTime){}
    public function setUpdateTime($updateTime){}
    public function setStoreId($storeId){}
}