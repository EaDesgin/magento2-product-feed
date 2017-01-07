<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CategoryLink
 * @package Eadesigndev\Productfeed\Model\ResourceModel
 * Adding the category system to the application to get he category product utl link and deepest category.
 */
class CategoryLink extends AbstractDb
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        $connectionName = null
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context, $connectionName);
    }

    /**
     * Getting in the database zone!
     */
    protected function _construct()
    {
        $this->_init('catalog_category_entity', 'entity_id');
    }
}