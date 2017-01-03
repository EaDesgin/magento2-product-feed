<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model;

use Magento\Framework\ObjectManagerInterface;


class FeedFactory implements FactoryInterface
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $_objectManager = null;
    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;
    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(ObjectManagerInterface $objectManager, $instanceName = Feed::class)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName  = $instanceName;
    }
    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Eadesigndev\Productfeed\Api\Data\FeedInterface
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }

}