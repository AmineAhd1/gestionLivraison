<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Package;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Norsys\Package\Model\PackageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Registry;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Image\AdapterFactory;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Norsys\Ticket\Model\TicketAttachmentFactory;
use Norsys\Ticket\Model\TicketFactory;

class SaveReturn extends Action {

    /** @var PageFactory $_pageFactory */
    protected PageFactory $_pageFactory;

    /** @var TicketFactory $_ticketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var \Norsys\Package\Model\PackageFactory $_packageFactory */
    protected $_packageFactory;

    /** @var PackageTrackingFactory */
    protected PackageTrackingFactory $_packageTrackingFactory;

    /** @var PackageStatusFactory */
    protected PackageStatusFactory $_packageStatusFactory;

    /** @var TicketAttachmentFactory $_ticketAttachmentFactory */
    protected TicketAttachmentFactory $_ticketAttachmentFactory;

    /** @var Filesystem $_fileSystem */
    protected Filesystem $_fileSystem;

    /** @var Session $authSession */
    protected $authSession;

    /** @var Registry */
    protected Registry $coreRegistry;

    /** @var */
    protected $_date;

    /** @var UploaderFactory $_fileUploaderFactory */
    protected UploaderFactory $_fileUploaderFactory;

    /** @var AdapterFactory $_adapterFactory */
    protected AdapterFactory $_adapterFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param TicketFactory $ticketFactory
     * @param TicketAttachmentFactory $ticketAttachmentFactory
     * @param Filesystem $filesystem
     * @param PackageFactory $_packageFactory
     * @param Session $authSession
     * @param UploaderFactory $fileUploaderFactory
     * @param Registry $coreRegistry
     * @param AdapterFactory $adapterFactory
     * @param PackageStatusFactory $_packageStatusFactory
     * @param PackageTrackingFactory $_packageTrackingFactory
     * @param TimezoneInterface $date
     */
    public function __construct(
        Context                 $context,
        PageFactory             $pageFactory,
        TicketFactory           $ticketFactory,
        TicketAttachmentFactory $ticketAttachmentFactory,
        Filesystem              $filesystem,
        PackageFactory          $_packageFactory,
        Session                 $authSession,
        UploaderFactory         $fileUploaderFactory,
        Registry                $coreRegistry,
        AdapterFactory          $adapterFactory,
        PackageStatusFactory    $_packageStatusFactory,
        PackageTrackingFactory  $_packageTrackingFactory,
        TimezoneInterface       $date

    ) {
        $this->_pageFactory = $pageFactory;
        $this->authSession = $authSession;
        $this->_packageStatusFactory = $_packageStatusFactory;
        $this->_packageTrackingFactory = $_packageTrackingFactory;
        $this->coreRegistry = $coreRegistry;
        $this->_ticketFactory = $ticketFactory;
        $this->_packageFactory = $_packageFactory;
        $this->_ticketAttachmentFactory = $ticketAttachmentFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_adapterFactory = $adapterFactory;
        $this->_fileSystem = $filesystem;
        $this->_date = $date;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface
     * @throws \Exception
     */
    public function execute(): ResponseInterface {
        $params = $this->getRequest()->getParams();
        /** @var string $customerSession */
        $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
        /** @var string $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();
        /** @var  \Norsys\Ticket\Model\Ticket $ticket */
        $ticket = $this->_ticketFactory->create();
        /** @var \Norsys\Package\Model\Package $packageFactory */
        $packageFactory = $this->_packageFactory->create();
        /** @var \Norsys\Ticket\Model\TicketAttachment $ticketAttachment */
        $attachment = $this->_ticketAttachmentFactory->create();

        /** save ticket info */
        $ticket->addData($params);
        $ticket->setStatus('Pending');
        $ticket->setType('Return Package');
        $ticket->setEmergency('High');
        $ticket->setUserClId($connectedUserId);
        $packageId = $this->getRequest()->getParam('package_id');
        $ticket->setPackageId($packageId);
        $ticket->save();
        $statusId = $this->_packageStatusFactory->create()->getCollection()
            ->addFieldToFilter('title', ['eq' => 'Returned'])
            ->getFirstItem()
            ->getData('packageStatus_id');
        $packageTrackingFactory = $this->_packageTrackingFactory->create();
        $packageTrackingFactory->setData('packageStatus_id', $statusId);
        $packageTrackingFactory->setData('package_id', $packageId);
        $packageTrackingFactory->setData('created_at', $this->_date->date()
            ->format('Y-m-d H:i:s'));
        $packageTrackingFactory->save();
        /** upload ticket attachment */
        try {
            /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'file']);
            /** Allowed extension types */
            $uploader->setAllowedExtensions([
                'jpg',
                'pdf',
                'doc',
                'png',
                'zip',
                'doc',
            ]);
            $fileAdapter = $this->_adapterFactory->create();
            /** rename file name if already exists */
            $uploader->setAllowRenameFiles(TRUE);
            $uploader->setFilesDispersion(TRUE);
            /**  allow folder creation */
            $uploader->setAllowCreateFolders(TRUE);
            /** @var  \Magento\Framework\Filesystem\Directory\WriteInterface $mediaDirectory */
            $mediaDirectory = $this->_fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
            /** @var string $target */
            $target = $mediaDirectory->getAbsolutePath('ticketAttachments/');
            /** upload file in folder "ticketAttachments" */
            $filename = $uploader->save($target);
            /** save ticket attachment */
            $attachment->setTicketId($ticket->getTicketId());
            $attachment->setFile($filename['file']);
            $attachment->save();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage("No ticket attachment placed ");
        }
        $this->messageManager->addSuccessMessage(__("Ticket successfully added "));
        $this->messageManager->addSuccessMessage(__("If your ticket is validated you will receive an email with details"));
        return $this->_redirect('*/*/viewReturn');
    }


}
