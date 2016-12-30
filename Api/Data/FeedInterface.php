<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Api\Data;


interface FeedInterface
{

    const ENTITY_ID  = 'entity_id';
    const IS_ACTIVE = 'is_active';
    const NAME = 'name';
    const FILENAME = 'filename';
    const URL = 'url';
    const DESCRIPTION = 'description';
    const DELIMITER = 'delimiter';
    const STOCK_STATUS = 'stock_status';
    const STATUS = 'status';
    const VISIBILITY = 'visibility';
    const CATEGORIES = 'categories';
    const FIELDS = 'fields';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const STORE_ID = 'store_id';

    public function getEntityId();
    public function getIsActive();
    public function getName();
    public function getFileName();
    public function getUrl();
    public function getDescription();
    public function getDelimiter();
    public function getStockStatus();
    public function getStatus();
    public function getVisibility();
    public function getCategories();
    public function getFields();
    public function getCreationTime();
    public function getUpdateTime();
    public function getStoreId();

    public function setEntityId($id);
    public function setIsActive($isActive);
    public function setName($name);
    public function setFileName($fileName);
    public function setUrl($url);
    public function setDescription($description);
    public function setDelimiter($delimiter);
    public function setStockStatus($stickStatus);
    public function setStatus($status);
    public function setVisibility($visibility);
    public function setCategories($categories);
    public function setFields($fields);
    public function setCreationTime($creationTime);
    public function setUpdateTime($updateTime);
    public function setStoreId($storeId);

}