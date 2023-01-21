<?php

declare(strict_types=1);

namespace Norsys\Ticket\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Result\PageFactory;
use Norsys\Ticket\Model\TicketFactory;

class Ticket extends Template
{

    /** @var PageFactory  $_pageFactory*/
    protected PageFactory $_pageFactory;

    /** @var TicketFactory $_ticketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var Session */
    protected Session $_customerSession;

    /**
     * @param Template\Context $context
     * @param PageFactory $pageFactory
     * @param TicketFactory $ticketFactory
     * @param Session $customerSession
     */
    public function __construct(
        Template\Context $context,
        PageFactory $pageFactory,
        TicketFactory  $ticketFactory,
        Session $customerSession
    ) {
        $this->_customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->_ticketFactory= $ticketFactory;
        return parent::__construct($context);
    }


    /**
     * @return string
     */
    public function getPostUrl(): string
    {
        return $this->getUrl('ticket/ticket/save');
    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getTicketByCustomerId(){
        /** @var string $customerId  */
        $customerId=$this->_customerSession->getCustomer()->getId();
        $collection=$this->_ticketFactory->create()->getCollection();
        return $collection->addFieldToFilter('customer_id', array('eq' =>$customerId ));

    }

    /**
     * @param $ticket
     * @return string
     */
    public function getViewUrl($ticket): string
    {
        return $this->getUrl('ticket/ticket/view', ['ticket_id' => $ticket->getId()]);
    }


}
