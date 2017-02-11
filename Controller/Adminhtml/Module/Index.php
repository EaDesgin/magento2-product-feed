<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Controller\Adminhtml\Module;

use Eadesigndev\Productfeed\Controller\Adminhtml\AbstractController;

class Index extends AbstractController
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(self::MODULE.'::productfeed');
        $resultPage->getConfig()->getTitle()->prepend(__('Product Feeds'));
        $resultPage->addBreadcrumb(__('Feeds'), __('Feeds'));
        $resultPage->addBreadcrumb(__('Grid'), __('Grid'));
        return $resultPage;
    }

}