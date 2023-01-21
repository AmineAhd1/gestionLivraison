<?php
declare(strict_types=1);

namespace Norsys\Task\Controller\adminhtml\Stafftptask;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Norsys\Task\Model\TaskFactory;
use Norsys\Ticket\Model\TicketFactory;

class Edit extends Action
{
    /** @var bool|PageFactory $_resultPageFactory */
    protected $_resultPageFactory = false;
    /** * @var TaskFactory $taskFactory */
    protected $taskFactory;
    /**  * @var TicketFactory $ticketFactory */
    protected $ticketFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Norsys\Task\Model\TaskFactory      $taskFactory,
        \Norsys\Ticket\Model\TicketFactory  $ticketFactory,
        \Magento\Backend\App\Action\Context $context,
        PageFactory                         $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->taskFactory = $taskFactory;
        $this->ticketFactory = $ticketFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page|void
     */
    public function execute()
    {
        $task = $this->taskFactory->create()->load($this->getRequest()->getParam("id"));
        $task->setStatus("completed");
        $ticket = $this->ticketFactory->create()->load($task->getTicketId());
        $ticket->setStatus("Resolved");
        $task->save();
        $ticket->save();

        $resultRedirect = $this->resultRedirectFactory->create();
        $this->messageManager->addSuccess(__("Your task is updated."));
        return $resultRedirect->setPath('task/stafftptask/index', array('_current' => true));
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Norsys_Task::task_management');
    }
}
