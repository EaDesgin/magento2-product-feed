<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

/** @var \Eadesigndev\Productfeed\Model\Feed $feed */
$feed = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('Eadesigndev\Productfeed\Model\Feed');
$feed->isObjectNew(true);
$feed->setId(
    22
)->setIsActive(
    1
)->setName(
    'Feed 1'
)->setFileName(
    'theFileName'
)->setUrl(
    'theUrl'
)->setDescription(
    'theDescription'
)->setDelimiter(
    ','
)->setStockStatus(
    1
)->setStatus(
    1
)->setVisibility(
    1
)->setCategories(
    '0'
)->setFields(
    serialize(['name','url','stock','status'])
)->setUpdateTime(
    '2016-06-23 09:50:07'
)->setStoreId(
1
)->save();
