<?php

declare(strict_types=1);

namespace Norsys\Ticket\Block\Adminhtml\Ticket;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class Detail extends Container {

    /** @var UrlInterface $urlBuilder */
    protected UrlInterface $urlBuilder;

    /** @var string $_blockGroup */
    protected $_blockGroup = 'Norsys_Ticket';

    /** * @var \Norsys\Task\Model\TaskFactory $_taskFactory */
    protected $_taskFactory;

    /**
     * @param \Norsys\Task\Model\ResourceModel\Task\CollectionFactory $_taskFactory
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        \Norsys\Task\Model\ResourceModel\Task\CollectionFactory $_taskFactory,
        Context                                                 $context,
        UrlInterface                                            $urlBuilder,
        array                                                   $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->_taskFactory = $_taskFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _construct() {
        $this->_objectId = 'ticket_id';
        $this->_controller = 'adminhtml_ticket';
        $this->_mode = 'view';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        /** @var String $impact */
        $impact = $this->getRequest()->getParam('impact');
        /** @var String $status */
        $status = $this->getRequest()->getParam('status');
        /** @var String $ticketId */
        $ticketId = $this->getRequest()->getParam('id');
        if (isset($ticketId) and isset($status)) {
            $this->addButton(
                'ticket_delete',
                [
                    'on_click' => 'deleteConfirm(\''
                        . __('Are you sure you want to delete this ticket ?')
                        . '\', \'' . $this->getDeleteUrl() . '\')',
                    'label' => __('Delete'),
                    'class' => 'edit primary',
                ]
            );
            if ($status != 'Resolved' and $status != 'Rejected' and !isset($impact)) {
                $this->addButton(
                    'ticket_reject',
                    [
                        'label' => __('Reject'),
                        'onclick' => "confirmSetLocation('Are you sure you want to reject this ticket ? ','{$this->getRejectUrl()}')",
                    ]
                );
            }
            if (isset($impact) and $status != 'Rejected' and $status != 'Resolved') {
                $this->addButton(
                    'ticket_resolve',
                    [
                        'label' => __('Resolve'),
                        'onclick' => "confirmSetLocation('Are you sure you want to resolve this ticket ? ','{$this->getResolveUrl()}')",
                    ]
                );
                $taskCollection = $this->_taskFactory->create();
                $tasks = $taskCollection->addFieldToFilter(
                    "ticket_id",
                    [
                        "eq" => $this->getRequest()->getParam('id'),
                    ]
                )->toArray();
                if (count($tasks["items"]) == 0) {
                    $this->addButton(
                        'ticket_add_task',
                        [
                            'label' => __('Assign Task'),
                            'onclick' => "confirmSetLocation('Are you sure you want to add new task on this ticket ? ','{$this->getAddTaskUrl()}')",
                        ]
                    );
                }
            }
            if (!isset($impact)) {
                $this->addButton(
                    'ticket_validate',
                    [
                        'label' => __('Validate'),
                        'onclick' => "confirmSetLocation('Are you sure you want to validate this ticket ? ','{$this->getValidateUrl()}')",
                        'class' => 'edit primary',
                    ]
                );
            }
        }

    }

    /**
     * @return string
     */
    public function getValidateUrl(): string {
        return $this->getUrl('ticket/ticket/validate', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return string
     */
    public function getDeleteUrl(): string {
        return $this->getUrl('ticket/ticket/delete', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return string
     */
    public function getResolveUrl(): string {
        return $this->getUrl('ticket/ticket/resolve', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return string
     */
    public function getAddTaskUrl() {
        return $this->getUrl('task/task/store', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return string
     */
    public function getRejectUrl(): string {
        return $this->getUrl('ticket/ticket/reject', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

}
