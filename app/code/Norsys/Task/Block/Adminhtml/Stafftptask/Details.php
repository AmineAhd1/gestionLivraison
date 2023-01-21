<?php
declare(strict_types=1);

namespace Norsys\Task\Block\Adminhtml\Stafftptask;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class Details extends Container
{
    /** @var UrlInterface $urlBuilder */
    protected UrlInterface $urlBuilder;

    /** @var string $_blockGroup */
    protected $_blockGroup = 'Norsys_Task';
    /** * @var \Norsys\Task\Model\TaskFactory $_taskFactory */
    protected $_taskFactory;

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        \Norsys\Task\Model\TaskFactory $_taskFactory,
        Context                        $context,
        UrlInterface                   $urlBuilder,
        array                          $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->_taskFactory = $_taskFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'task_id';
        $this->_controller = 'adminhtml_stafftptask';
        $this->_mode = 'view';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        $taskCollection = $this->_taskFactory->create();
        if ($taskCollection->load($this->getRequest()->getParam("id"))->getStatus() != "completed") {
            $this->addButton(
                'completed',
                [
                    'on_click' => "setLocation('" . $this->changeStatus() . "')",
                    'label' => __('Mark as completed'),
                    'class' => 'edit primary'
                ]
            );
        }
    }

    /**
     * @return string
     */
    public function changeStatus()
    {
        return $this->urlBuilder->getUrl('task/stafftptask/edit/id/' . $this->getRequest()->getParam("id"));
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Norsys_Task::task_management');
    }
}
