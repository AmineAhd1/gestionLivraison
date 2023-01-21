<?php

declare(strict_types=1);

namespace Norsys\Ticket\Controller\Adminhtml\Ticket;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Norsys\Ticket\Model\TicketFactory;

class Delete extends Action
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
     */
    public function execute(): ResponseInterface
    {
        /** @var string $ticketId  */
        $ticketId =$this->getRequest()->getParam('id');
        $ticket=$this->_ticketFactory->create()->load($ticketId);
        try{
            $ticket->delete();
            $this->messageManager->addSuccess(__('The ticket has been deleted !'));
        } catch (Exception  $e) {
            $this->messageManager->addError(__('Error while trying to delete ticket: '));
            return $this->_redirect('ticket/ticket/index',array('_current' => true));
        }
        return $this->_redirect('ticket/ticket/index');
    }

}
