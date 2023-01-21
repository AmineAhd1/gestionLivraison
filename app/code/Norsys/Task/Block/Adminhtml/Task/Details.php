<?php
declare(strict_types=1);
namespace Norsys\Task\Block\Adminhtml\Task;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class Details extends Container
{
    /** @var UrlInterface $urlBuilder*/
    protected UrlInterface $urlBuilder;

    /** @var string $_blockGroup */
    protected $_blockGroup = 'Norsys_Task';

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'task_id';
        $this->_controller = 'adminhtml_task';
        $this->_mode = 'view';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
    }
}
