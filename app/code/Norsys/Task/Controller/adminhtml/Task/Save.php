<?php
declare(strict_types=1);

namespace Norsys\Task\Controller\adminhtml\Task;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Save extends Action
{
    /** @var bool|PageFactory $_resultPageFactory */
    protected $_resultPageFactory = false;
    /** * @var \Norsys\Task\Model\TaskFactory $_taskFactory */
    protected $_taskFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Norsys\Task\Model\TaskFactory      $_taskFactory,
        \Magento\Backend\App\Action\Context $context,
        PageFactory                         $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->_taskFactory = $_taskFactory;
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
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
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Norsys_Ticket::menu');
    }
}
