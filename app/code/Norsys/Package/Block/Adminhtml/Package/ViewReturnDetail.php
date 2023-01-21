<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class ViewReturnDetail extends Container {

    /** @var UrlInterface $urlBuilder */
    protected UrlInterface $urlBuilder;

    /** @var string $_blockGroup */
    protected $_blockGroup = 'Norsys_Package';

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Context      $context,
        UrlInterface $urlBuilder,
        array        $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
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
        $this->_controller = 'adminhtml_package';
        $this->_mode = 'ViewReturnDetail';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
    }

}

