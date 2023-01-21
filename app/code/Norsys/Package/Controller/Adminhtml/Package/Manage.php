<?php
declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Package;

use Norsys\Package\Model\PackageFactory;

class Manage extends \Magento\Backend\App\Action {

    /** @var bool|\Magento\Framework\View\Result\PageFactory $resultPageFactory */
    protected $resultPageFactory = FALSE;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page\Interceptor
     */
    public function execute() {
        /** @var \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()
                   ->getTitle()
                   ->prepend((__('Packages Management')));
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool {
        return $this->_authorization->isAllowed('Norsys_Package::packages_management');
    }

}
