<?php
declare(strict_types=1);

namespace Norsys\Task\Controller\adminhtml\Task;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Store extends Action
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
     * @return ResponseInterface|ResultInterface|Page|void
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->getParam("title") != null) {
            $task = $this->_taskFactory->create();
            $task->setTitle($this->getRequest()->getParam("title"));
            $task->setDescription($this->getRequest()->getParam("description"));
            $task->setStatus("assigned");
            $task->setAdminUserId($this->getRequest()->getParam("user_id"));
            $task->setTicketId($this->getRequest()->getParam("id"));
            try {
                $task->save();
                $this->messageManager->addSuccess(__("your task on ticket has been added successfully !"));
            } catch (\Exception $exception) {
                $this->messageManager->addSuccess(__($exception->getMessage()));
            }
            return $resultRedirect->setPath('task/task/index', array('_current' => true));
        } else {
            $resultPage = $this->_resultPageFactory->create();
            $resultPage->setActiveMenu('Norsys_Ticket::menu');
            $resultPage->getConfig()->getTitle()->prepend(__('Add New Task'));
            return $resultPage;
        }
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Norsys_Ticket::menu');
    }
}
