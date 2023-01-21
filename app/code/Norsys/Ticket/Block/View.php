<?php

declare(strict_types=1);

namespace Norsys\Ticket\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Result\PageFactory;
use Norsys\Ticket\Model\TicketAttachmentFactory;
use Norsys\Ticket\Model\TicketFactory;

class View extends Template
{

    /** @var PageFactory  $_pageFactory*/
    protected PageFactory $_pageFactory;

    /** @var TicketFactory $_ticketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var TicketAttachmentFactory $_ticketAttachmentFactory */
    protected TicketAttachmentFactory $_ticketAttachmentFactory;

    /** @var Session */
    protected Session $_customerSession;

    /**
     * @param Template\Context $context
     * @param PageFactory $pageFactory
     * @param TicketFactory $ticketFactory
     * @param TicketAttachmentFactory $ticketAttachmentFactory
     * @param Session $customerSession
     */
    public function __construct(
        Template\Context $context,
        PageFactory $pageFactory,
        TicketFactory  $ticketFactory,
        TicketAttachmentFactory  $ticketAttachmentFactory,
        Session $customerSession
    ) {
        $this->_customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->_ticketFactory= $ticketFactory;
        $this->_ticketAttachmentFactory= $ticketAttachmentFactory;
        return parent::__construct($context);
    }

    /**
     * @return \Norsys\Ticket\Model\Ticket
     */
    public function getTicket(): \Norsys\Ticket\Model\Ticket
    {
        /** @var string $id  */
        $id = $this->getRequest()->getParam('ticket_id');
        return $this->_ticketFactory->create()->load($id);
    }


    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getPath(): string
    {
        $path=$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $path.'ticketAttachments';
    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getTicketAttachment()
    {
        $ticketId = $this->getRequest()->getParam('ticket_id');
        $ticketAttachment=$this->_ticketAttachmentFactory->create()->getCollection();
        return $ticketAttachment->addFieldToFilter('ticket_id', array('eq' =>$ticketId));
    }

}
