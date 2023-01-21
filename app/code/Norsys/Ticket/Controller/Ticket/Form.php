<?php

declare(strict_types=1);

namespace Norsys\Ticket\Controller\Ticket;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Form extends Action
{
    /** @var PageFactory  $_pageFactory */
    protected PageFactory $_pageFactory;


    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context      $context,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {

        $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
        $urlInterface = $this->_objectManager->get('\Magento\Framework\UrlInterface');
        if ($customerSession->isLoggedIn()) {
            return $this->_pageFactory->create();
        } else {
            $customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
            $customerSession->authenticate();
        }

    }
}