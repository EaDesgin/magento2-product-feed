<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model\ResourceModel;

use Eadesigndev\Productfeed\Setup\InstallSchema;
use Eadesigndev\Productfeed\Api\Data\FeedInterface;
use Eadesigndev\Productfeed\Model\Feed as FeedModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Model\AbstractModel;


class Feed extends AbstractDb
{

    private $storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(
            InstallSchema::MAIN_TABLE,
            FeedInterface::ENTITY_ID
        );
    }

    protected function _afterSave(AbstractModel $object)
    {
        $this->saveStoreRelation($object);
        return parent::_afterSave($object);
    }

    protected function _afterLoad(AbstractModel $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData(FeedInterface::STORE_ID, $stores);
        }

        return parent::_afterLoad($object);
    }

    protected function _beforeDelete(AbstractModel $object)
    {
        $condition = [FeedInterface::ENTITY_ID . ' = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable(InstallSchema::STORE_TABLE), $condition);

        return parent::_beforeDelete($object);
    }

    public function lookupStoreIds($feedId)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()->from(
            $this->getTable(InstallSchema::STORE_TABLE),
            FeedInterface::STORE_ID
        )->where(
            FeedInterface::ENTITY_ID . ' = ?',
            (int)$feedId
        );

        return $adapter->fetchCol($select);
    }

    protected function saveStoreRelation(FeedModel $feed)
    {
        $oldStores = $this->lookupStoreIds($feed->getId());
        $newStores = (array)$feed->getStoreId();

        if (empty($newStores)) {
            $newStores = (array)$feed->getStoreId();
        }

        $table = $this->getTable(InstallSchema::STORE_TABLE);
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = [
                FeedInterface::ENTITY_ID . ' = ?' => (int)$feed->getId(),
                FeedInterface::STORE_ID . ' IN (?)' => $delete
            ];

            $this->getConnection()->delete($table, $where);
        }

        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    FeedInterface::ENTITY_ID => (int)$feed->getId(),
                    FeedInterface::STORE_ID => (int)$storeId
                ];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }

        return $this;
    }

}