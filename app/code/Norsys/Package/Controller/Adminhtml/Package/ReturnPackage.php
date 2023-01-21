<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Package;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class ReturnPackage extends \Magento\Backend\App\Action
{

    /** @var bool|PageFactory $resultPageFactory */
    protected $resultPageFactory = FALSE;

    /** @var Registry */
    protected Registry $coreRegistry;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var string $packageId */
        $packageId = $this->getRequest()->getParam('package_id');
        $this->coreRegistry->register('package_id', $packageId);
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()
        ->getTitle()
        ->prepend((__('Return On Package')));
        return $resultPage;
    }

}