<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Model\UrlInterface;

class ReturnPackage extends \Magento\Backend\Block\Widget\Form\Container {

    /** * @var UrlInterface $_backendUrl */
    protected $_backendUrl;

    /**
     * @param UrlInterface $backendUrl
     * @param Context $context
     * @param array $data
     */
    public function __construct(UrlInterface $backendUrl, Context $context, array $data = []) {
        $this->_backendUrl = $backendUrl;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct() {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Norsys_Package';
        $this->_controller = 'Adminhtml_Package';
        $this->_mode = "ReturnPackage";
        parent::_construct();
        $this->buttonList->remove('delete');
    }

}
