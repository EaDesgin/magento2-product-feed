<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;


abstract class AbstractController extends Action
{

    const MODULE = 'Eadesigndev_Productfeed';
    const ACTION_RESOURCE = 'Eadesigndev_Productfeed::all';

    protected $pageFactory;

    protected $forwardFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ForwardFactory $forwardFactory

    )
    {
        $this->pageFactory = $pageFactory;
        $this->forwardFactory = $forwardFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        // TODO: Implement execute() method.
    }
}