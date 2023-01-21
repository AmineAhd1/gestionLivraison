<?php

declare(strict_types=1);

namespace Norsys\Ticket\Controller\Adminhtml\Ticket;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Norsys\Ticket\Model\TicketFactory;

class Resolve extends Action
{
    /** @var TicketFactory $_ticketFactory */
    protected TicketFactory $_ticketFactory;

    /**
     * @param Context $context
     * @param TicketFactory $ticketFactory
     */
    public function __construct(
        Context $context,
        TicketFactory  $ticketFactory
    )
    {
        parent::__construct($context);
        $this->_ticketFactory= $ticketFactory;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function execute(): ResponseInterface
    {
        /** @var string $ticketId  */
        $ticketId =$this->getRequest()->getParam('id');
        $ticket=$this->_ticketFactory->create()->load($ticketId);
        $ticket->setStatus('Resolved');
        $ticket->save();
        return $this->_redirect('ticket/ticket/index');
    }

}
