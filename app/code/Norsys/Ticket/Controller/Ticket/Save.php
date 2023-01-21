<?php

declare(strict_types=1);

namespace Norsys\Ticket\Controller\Ticket;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Norsys\Ticket\Model\TicketAttachmentFactory;
use Norsys\Ticket\Model\TicketFactory;

class Save extends Action
{
    /** @var PageFactory $_pageFactory */
    protected PageFactory $_pageFactory;

    /** @var TicketFactory $_ticketFactory */
    protected TicketFactory $_ticketFactory;

    /** @var TicketAttachmentFactory $_ticketAttachmentFactory */
    protected TicketAttachmentFactory $_ticketAttachmentFactory;

    /** @var Filesystem $_fileSystem */
    protected Filesystem $_fileSystem;

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
     * @param UploaderFactory $fileUploaderFactory
     * @param AdapterFactory $adapterFactory
     */
    public function __construct(
        Context                 $context,
        PageFactory             $pageFactory,
        TicketFactory           $ticketFactory,
        TicketAttachmentFactory $ticketAttachmentFactory,
        Filesystem              $filesystem,
        UploaderFactory         $fileUploaderFactory,
        AdapterFactory          $adapterFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_ticketFactory = $ticketFactory;
        $this->_ticketAttachmentFactory = $ticketAttachmentFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_adapterFactory = $adapterFactory;
        $this->_fileSystem = $filesystem;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $params = $this->getRequest()->getParams();
        $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
        $customerId=$customerSession->getCustomer()->getId();
        $ticket=$this->_ticketFactory->create();
        $attachment=$this->_ticketAttachmentFactory->create();
        try {
            /** save ticket info */
            $ticket->addData($params);
            $ticket->setStatus('Pending');
            $ticket->setCustomerId($customerId);
            $ticket->save();
            /** upload ticket attachment */
            try{
                $uploader = $this->_fileUploaderFactory->create(['fileId' => 'file']);
                /** Allowed extension types */
                $uploader->setAllowedExtensions(['jpg', 'pdf', 'doc', 'png', 'zip', 'doc']);
                $fileAdapter=$this->_adapterFactory->create();
                /** rename file name if already exists */
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                /**  allow folder creation */
                $uploader->setAllowCreateFolders(true);
                $mediaDirectory=$this->_fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
                $target = $mediaDirectory->getAbsolutePath('ticketAttachments/');
                /** upload file in folder "ticketAttachments" */
                $filename=$uploader->save($target);
                /** save ticket attachment */
                $attachment->setTicketId($ticket->getTicketId());
                $attachment->setFile($filename['file']);
                $attachment->save();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage("No ticket attachment placed ");
            }
            $this->messageManager->addSuccessMessage(__("Ticket successfully added "));
            $this->messageManager->addSuccessMessage(__("If your ticket is validated you will receive an email with details"));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something went wrong. Try another time ."));
        }
        return $this->_redirect('ticket/ticket/form');
    }


}
