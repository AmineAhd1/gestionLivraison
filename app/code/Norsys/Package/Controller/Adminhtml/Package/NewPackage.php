<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Package;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ResponseInterface;
use Norsys\Package\Model\Package;

class NewPackage extends \Magento\Backend\App\Action {

    /** @var bool|\Magento\Framework\View\Result\PageFactory $resultPageFactory */
    protected $resultPageFactory = FALSE;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute() {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('ADD New Packages')));
        return $resultPage;
    }

}
