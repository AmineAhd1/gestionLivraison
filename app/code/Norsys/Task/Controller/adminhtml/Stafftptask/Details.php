<?php
declare(strict_types=1);
namespace Norsys\Task\Controller\adminhtml\Stafftptask;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Details extends Action
{
    /** @var bool|PageFactory $_resultPageFactory */
    protected $_resultPageFactory = false;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PageFactory                         $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Norsys_Ticket::menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Task Details'));
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Norsys_Task::task_management');
    }

}
