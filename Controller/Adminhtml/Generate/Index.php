<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Eadesigndev\Productfeed\Controller\Adminhtml\Generate;

use Eadesigndev\Productfeed\Controller\Adminhtml\AbstractController;
use Eadesigndev\Productfeed\Model\Generate\Feed as GenerateFeed;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Used to generate the feed
 * Class Index
 * @package Eadesigndev\Productfeed\Controller\Adminhtml\Generate
 */
class Index extends AbstractController
{

    /**
     * @var GenerateFeed
     */
    private $generateFeed;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param GenerateFeed $generateFeed
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        GenerateFeed $generateFeed
    )
    {
        $this->generateFeed = $generateFeed;
        parent::__construct($context,$pageFactory);
    }

    /**
     * Generate feed controller
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        $this->generateFeed->generate();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(self::MODULE.'::feeds');
        $resultPage->getConfig()->getTitle()->prepend(__('Feed'));
        return $resultPage;
    }


}
