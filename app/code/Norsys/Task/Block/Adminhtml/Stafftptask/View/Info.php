<?php
declare(strict_types=1);
namespace Norsys\Task\Block\Adminhtml\Stafftptask\View;
use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Model\UrlInterface;

class Info extends Widget
{
    /** * @var \Norsys\Task\Model\TaskFactory $taskFactory */
    protected $taskFactory;
    /** * @var \Norsys\Ticket\Model\TicketFactory $ticketFactory */
    protected $ticketFactory;
    /** * @var Integer $ticketId */
    protected $ticketId;

    public function __construct(
        UrlInterface $backendUrl,
        \Norsys\Task\Model\TaskFactory     $taskFactory,
        \Norsys\Ticket\Model\TicketFactory $ticketFactory,
        Context                            $context,
        array                              $data = []
    )
    {
        $this->_backendUrl = $backendUrl;
        $this->taskFactory = $taskFactory;
        $this->ticketFactory = $ticketFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Norsys\Task\Model\Task
     */
    public function getTask(){
        return $this->taskFactory->create()->load($this->getRequest()->getParam("id"));
    }
    /**
     * @return \Norsys\Ticket\Model\Ticket
     */
    public function getTicket(){
        $task = $this->taskFactory->create()
            ->load($this->getRequest()->getParam("id"));
        return $this->ticketFactory->create()
            ->load( $task->getTicketId() );
    }
    /**
     * @param $id
     * @return string
     */
    public function getSenderUrl($id){
        return $this->_backendUrl->getUrl("ticket/ticket/detail/id/$id");
    }
}
