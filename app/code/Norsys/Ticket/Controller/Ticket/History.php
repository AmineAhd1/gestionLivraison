<?php

declare(strict_types=1);

namespace Norsys\Ticket\Controller\Ticket;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class History extends Action implements HttpGetActionInterface
{
    /** @var PageFactory $resultPageFactory */
    protected PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return Page|ResultInterface
     */
    public function execute()
    {
        /** @var object $customerSession */
        $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
        /** @var object $urlInterface  */
        $urlInterface = $this->_objectManager->get('\Magento\Framework\UrlInterface');
        if ($customerSession->isLoggedIn()) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__('My Tickets'));
            return $resultPage;
        }else {
            $customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
            $customerSession->authenticate();
        }
    }


}
