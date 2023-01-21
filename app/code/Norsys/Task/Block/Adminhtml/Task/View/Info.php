<?php
declare(strict_types=1);

namespace Norsys\Task\Block\Adminhtml\Task\View;

use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;
use Magento\User\Model\UserFactory;
use Magento\Backend\Model\UrlInterface;

class Info extends Widget {

    /** * @var \Norsys\Task\Model\TaskFactory $taskFactory */
    protected $taskFactory;

    /** * @var \Norsys\Ticket\Model\TicketFactory $ticketFactory */
    protected $ticketFactory;

    /** * @var UserFactory $userFactory */
    protected $userFactory;

    /** * @var Integer $userId */
    protected $userId;

    /** * @var Integer $ticketId */
    protected $ticketId;

    public function __construct(
        UrlInterface $backendUrl,
        \Norsys\Task\Model\TaskFactory $taskFactory,
        \Norsys\Ticket\Model\TicketFactory $ticketFactory,
        UserFactory $userFactory,
        Context $context,
        array $data = []
    ) {
        $this->_backendUrl   = $backendUrl;
        $this->taskFactory   = $taskFactory;
        $this->ticketFactory = $ticketFactory;
        $this->userFactory   = $userFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getTask() {
        $taskCollection = $this->taskFactory->create();
        $task           = $taskCollection->load($this->getRequest()
                                                     ->getParam("id"))
                                         ->toArray();
        $this->userId   = $task["admin_user_id"];
        $this->ticketId = $task["ticket_id"];
        return $taskCollection->load($this->getRequest()->getParam("id"))
                              ->toArray();
    }

    /**
     * @return array
     */
    public function getUser() {
        return $this->userFactory->create()->load($this->userId)->toArray();
    }

    /**
     * @return array
     */
    public function getTicket() {
        return $this->ticketFactory->create()->load($this->ticketId)->toArray();
    }

    /**
     * @param int $ticketId
     *
     * @return string
     */
    public function getSenderUrl(int $ticketId) {
        $ticketCollection = $this->ticketFactory->create();
        $ticket           = $ticketCollection->load($ticketId);
        return $this->_backendUrl->getUrl(
            "ticket/ticket/detail/id/" . $ticketId . '/impact/' . $ticket->getImpact() . '/status/' . $ticket->getStatus() . ''
        );
    }

}
