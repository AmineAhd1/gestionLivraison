<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package\ViewReturnDetail;

use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\UrlInterface;
use Magento\User\Model\UserFactory;
use Norsys\Package\Model\PackageFactory;
use Norsys\Ticket\Model\Ticket;
use Norsys\Package\Model\Package;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;
use Norsys\Ticket\Model\TicketAttachmentFactory;
use Norsys\Ticket\Model\TicketFactory;

class Info extends Widget {

    /** @var TicketFactory $_ticketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var \Norsys\Package\Model\PackageTrackingFactory  */
    protected packageTrackingFactory $_packageTrackingFactory;

    /** @var \Norsys\Package\Model\PackageStatusFactory  */
    protected packageStatusFactory $_packageStatusFactory;

    /** @var TicketAttachmentFactory $_ticketAttachmentFactory */
    protected TicketAttachmentFactory $_ticketAttachmentFactory;

    /** @var UserFactory $_userFactory */
    protected UserFactory $_userFactory;

    /** @var \Norsys\Package\Model\PackageFactory $_packageFactory */
    protected $_packageFactory;

    /**
     * @param Context $context
     * @param UserFactory $userFactory
     * @param \Norsys\Package\Model\PackageFactory $_packageFactory
     * @param TicketFactory $ticketFactory
     * @param packageTrackingFactory $_packageTrackingFactory
     * @param packageStatusFactory $_packageStatusFactory
     * @param TicketAttachmentFactory $ticketAttachmentFactory
     * @param array $data
     */
    public function __construct(
        Context                 $context,
        TicketFactory           $ticketFactory,
        TicketAttachmentFactory $ticketAttachmentFactory,
        PackageFactory          $_packageFactory,
        packageTrackingFactory  $_packageTrackingFactory,
        packageStatusFactory    $_packageStatusFactory,
        UserFactory             $userFactory,
        array                   $data = []
    ) {
        $this->_ticketFactory = $ticketFactory;
        $this->_ticketAttachmentFactory = $ticketAttachmentFactory;
        $this->_packageFactory = $_packageFactory;
        $this->_packageTrackingFactory = $_packageTrackingFactory;
        $this->_packageStatusFactory = $_packageStatusFactory;
        $this->_userFactory = $userFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return Ticket
     */
    public function getTicket(): Ticket {
        /** @var string $ticketId */
        $ticketId = $this->getRequest()->getParam('id');
        return $this->_ticketFactory->create()->load($ticketId);
    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getTicketAttachment() {
        /** @var string $ticketId */
        $ticketId = $this->getRequest()->getParam('id');
        /** @var \Norsys\Ticket\Model\ResourceModel\TicketAttachment\Collection $ticketAttachment */
        $ticketAttachment = $this->_ticketAttachmentFactory->create()
            ->getCollection();
        return $ticketAttachment->addFieldToFilter('ticket_id', ['eq' => $ticketId]);
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
     * @return \Magento\User\Model\User
     */
    public function getUser() {
        /** @var string $ticketId */
        $ticketId = $this->getRequest()->getParam('id');
        $ticket = $this->_ticketFactory->create()->load($ticketId);
        /** @var string $userId */
        $userId = $ticket->getUserClId();
        return $this->_userFactory->create()->load($userId);
    }

    public function getPackageInfo() {
        /** @var string $ticketId */
        $ticketId = $this->getRequest()->getParam('id');
        $ticket = $this->_ticketFactory->create()->load($ticketId);
        /** @var string $packageId */
        $packageId = $ticket->getPackageId();
        return $this->_packageFactory->create()->load($packageId);
    }

    /**
     * @return null|String
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrentStatus(): ?string {
        if ($packageId = $this->getRequest()->getParam('package_id')) {
            return $this->_packageTrackingFactory->create()
                ->getCollection()
                ->addFieldToFilter('package_id', ['eq' => $packageId])
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                )
                ->setOrder('created_at', 'DESC')
                ->getFirstItem()
                ->getTitle();
        }
        return NULL;
    }

    /**
     * @param $id
     * @param $status
     *
     * @return string
     */
    public function getViewUrl($id, $status): string {
        return $this->getUrl('norsys_package/package/detail', [
            'id' => $id,
            'status' => $status,
        ]);
    }

}


