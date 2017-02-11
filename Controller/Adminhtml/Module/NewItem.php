<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Controller\Adminhtml\Module;


use Eadesigndev\Productfeed\Controller\Adminhtml\AbstractController;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewItem extends AbstractController
{

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        $resultForward = $this->forwardFactory->create();
        $resultForward->forward('edit');
        return $resultForward;
    }
}