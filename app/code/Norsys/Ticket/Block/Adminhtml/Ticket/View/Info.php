<?php

declare(strict_types=1);

namespace Norsys\Ticket\Block\Adminhtml\Ticket\View;

use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\UrlInterface;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Norsys\Ticket\Model\Ticket;
use Norsys\Ticket\Model\TicketAttachmentFactory;
use Norsys\Ticket\Model\TicketFactory;

class Info extends Widget {

    /** @var TicketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var TicketAttachmentFactory */
    protected TicketAttachmentFactory $_ticketAttachmentFactory;

    /** @var CustomerFactory */
    protected CustomerFactory $_customerFactory;

    /** @var UserFactory */
    protected UserFactory $_userFactory;

    /**
     * @param Context $context
     * @param TicketFactory $ticketFactory
     * @param TicketAttachmentFactory $ticketAttachmentFactory
     * @param CustomerFactory $customerFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param array $data
     */
    public function __construct(
        Context                 $context,
        TicketFactory           $ticketFactory,
        TicketAttachmentFactory $ticketAttachmentFactory,
        CustomerFactory         $customerFactory,
        UserFactory             $userFactory,
        array                   $data = []
    ) {
        $this->_ticketFactory = $ticketFactory;
        $this->_ticketAttachmentFactory = $ticketAttachmentFactory;
        $this->_customerFactory = $customerFactory;
        $this->_userFactory = $userFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Norsys\Ticket\Model\Ticket|null
     */
    public function getTicket(): ?Ticket {
        /** @var string $ticketId */
        if ($ticketId = $this->getRequest()->getParam('id')) {
            return $this->_ticketFactory->create()->load($ticketId);
        }
        return NULL;
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getTicketAttachment() {
        if ($ticketId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Ticket\Model\ResourceModel\TicketAttachment\Collection $ticketAttachment */
            $ticketAttachment = $this->_ticketAttachmentFactory->create()
                ->getCollection();
            return $ticketAttachment->addFieldToFilter('ticket_id', ['eq' => $ticketId]);
        }
        return NULL;
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getPath(): string {
        /** @var String $path */
        $path = $this->_storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $path . 'ticketAttachments';
    }

    /**
     * @return \Magento\Customer\Model\Customer|null
     */
    public function getCustomer(): ?Customer {
        if ($ticketId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Ticket\Model\Ticket $ticket */
            $ticket = $this->_ticketFactory->create()->load($ticketId);
            return $this->_customerFactory->create()
                ->load($ticket->getCustomerId());
        }
        return NULL;
    }

    /**
     * @return \Magento\User\Model\User|null
     */
    public function getUser(): ?User {
        if ($ticketId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Ticket\Model\Ticket $ticket */
            $ticket = $this->_ticketFactory->create()->load($ticketId);
            return $this->_userFactory->create()->load($ticket->getUserClId());
        }
        return NULL;
    }

}
