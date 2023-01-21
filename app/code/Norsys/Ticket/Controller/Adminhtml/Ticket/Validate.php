<?php

declare(strict_types=1);

namespace Norsys\Ticket\Controller\Adminhtml\Ticket;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\User\Model\UserFactory;
use Norsys\Ticket\Helper\Email;
use Norsys\Ticket\Model\TicketFactory;

class Validate extends Action
{
    /** @var TicketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var CustomerFactory */
    protected CustomerFactory $_customerFactory;

    /** @var UserFactory */
    protected UserFactory $_userFactory;

    /** @var ScopeConfigInterface */
    protected ScopeConfigInterface $_scopeConfig;

    /** * @var Email */
    protected Email $_emailHelper;

    /**
     * @param Context $context
     * @param TicketFactory $ticketFactory
     * @param CustomerFactory $customerFactory
     * @param UserFactory $userFactory
     * @param Email $emailHelper
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context              $context,
        TicketFactory        $ticketFactory,
        CustomerFactory      $customerFactory,
        UserFactory          $userFactory,
        Email                $emailHelper,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->_ticketFactory = $ticketFactory;
        $this->_customerFactory = $customerFactory;
        $this->_userFactory = $userFactory;
        $this->_emailHelper = $emailHelper;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return Redirect|ResultInterface|void
     * @throws Exception
     */
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
        /** @var array $ticketData */
        $ticketData = $this->getRequest()->getParam('ticket');
        if (!empty($ticketData)) {
            /** @var \Norsys\Ticket\Model\Ticket $ticket */
            $ticket = $this->_ticketFactory->create();
            $ticket->setData($ticketData);

            /* generating ticket priority  */
            $emergency = $ticketData['emergency'];
            $impact = $ticketData['impact'];
            if ($emergency === 'High' and $impact === 'High') {
                $ticket->setPriority('High');
            }
            elseif ($emergency === 'High' and $impact === 'Average') {
                $ticket->setPriority('High');
            }
            elseif ($emergency === 'High' and $impact === 'Low') {
                $ticket->setPriority('Average');
            }
            elseif ($emergency === 'Average' and $impact === 'High') {
                $ticket->setPriority('High');
            }
            elseif ($emergency === 'Average' and $impact === 'Average') {
                $ticket->setPriority('Average');
            }
            elseif ($emergency === 'Average' and $impact === 'Low') {
                $ticket->setPriority('Low');
            }
            elseif ($emergency === 'Low' and $impact === 'High') {
                $ticket->setPriority('Average');
            }
            elseif ($emergency === 'Low' and $impact === 'Average') {
                $ticket->setPriority('Average');
            }
            elseif ($emergency === 'Low' and $impact === 'Low') {
                $ticket->setPriority('Low');
            }
            /* sending ticket validation email  */
            $emailVariables = [];
            $receiver = [];
            if ($ticket->getCustomerId() !== NULL) {
                /** @var  \Magento\Customer\Model\Customer $customer */
                $customer = $this->_customerFactory->create()
                    ->load($ticket->getCustomerId());
                $emailVariables = [
                    'customerName' => $customer->getFirstname(),
                    'ticketTitle' => $ticket->getTitle(),
                    'ticketId' => $ticket->getTicketId(),
                ];

                $receiver = [
                    'name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
                    'email' => $customer->getEmail(),
                ];
            }
            elseif ($ticket->getUserClId() !== NULL) {
                /** @var \Magento\User\Model\User $user */
                $user = $this->_userFactory->create()
                    ->load($ticket->getUserClId());
                $emailVariables = [
                    'customerName' => $user->getFirstname(),
                    'ticketTitle' => $ticket->getTitle(),
                    'ticketId' => $ticket->getTicketId(),
                ];
                $receiver = [
                    'name' => $user->getFirstname() . ' ' . $user->getLastname(),
                    'email' => $user->getEmail(),
                ];
            }
            try {
                /** @var string $sender */
                $sender = $this->_scopeConfig->getValue('admin/emails/sender');
                $this->_emailHelper->sendTicketValidationEmail(
                    $emailVariables,
                    $sender,
                    $receiver
                );
                $ticket->setStatus('Processing');
                $ticket->save();
                $this->messageManager->addSuccessMessage('Ticket has been Validated');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage('Ticket Validation Failed');
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('ticket/ticket/index');
        }
    }

}
