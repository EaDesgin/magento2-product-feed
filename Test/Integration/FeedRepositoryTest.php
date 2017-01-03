<?php
/**
 * Copyright © 2016 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Test\Integration;


use Eadesigndev\Productfeed\Model\FeedRepository;
use Eadesigndev\Productfeed\Model\ResourceModel\Feed as FeedResourceModel;
use Eadesigndev\Productfeed\Model\FeedFactory;
use Eadesigndev\Productfeed\Model\Feed as FeedModel;
use Eadesigndev\Productfeed\Api\Data\FeedInterface;
use Magento\TestFramework\ObjectManager;

/**
 * Test for \Productfeed\Model\FeedRepository
 * Class FeedRepositoryTest
 * @package Eadesigndev\Productfeed\Test\Integration
 */
class FeedRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var /Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
     */
    public $objectManager;

    /**
     * @var FeedRepository
     */
    private $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Eadesigndev\Productfeed\Model\ResourceModel\Feed
     */
    private $feedResourceModel;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Eadesigndev\Productfeed\Model\FeedFactory
     */
    private $feedFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Eadesigndev\Productfeed\Api\Data\FeedInterface;
     */
    private $feed;

    public function setUp()
    {

        $this->objectManager = ObjectManager::getInstance();

        $this->feedResourceModel = $this->getMockBuilder(FeedResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->feedFactory = $this->getMockBuilder(FeedFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        /** @var FeedModel feed */
        $this->feed = $this->objectManager->create(FeedInterface::class);

        $this->feedFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->feed);

        $this->repository = new FeedRepository($this->feedResourceModel, $this->feedFactory);

    }

    public function testSave()
    {
        $this->feedResourceModel
            ->expects($this->once())
            ->method('save')
            ->with($this->feed)
            ->willReturnSelf();

        $this->assertEquals($this->feed, $this->repository->save($this->feed));
    }

    public function testGetById()
    {
        $id = 1;
        $this->feedResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->feed->setEntityId($id))
            ->willReturnSelf();

        $this->assertEquals($this->feed, $this->repository->getById($id));
    }

    public function testDelete()
    {

        $this->feedResourceModel
            ->expects($this->once())
            ->method('delete')
            ->with($this->feed)
            ->willReturnSelf();

        $this->assertTrue($this->repository->delete($this->feed));
    }

    public function testDeleteById()
    {
        $id = 1;

        $this->feedResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->feed->setEntityId($id))
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($id));
    }

    public function testCrud(){

        $feed = $this->feed;

        $feed->setStoreId(1);

        $crud = new \Magento\TestFramework\Entity($feed, ['name'=>'name']);
        $crud->testCrud();
    }

}
