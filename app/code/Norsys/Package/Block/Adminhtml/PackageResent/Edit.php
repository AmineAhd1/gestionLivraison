<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\PackageResent;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class Edit extends Container {

    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /** @var string */
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
        $this->_objectId = 'package_id';
        $this->_controller = 'adminhtml_packageResent';
        $this->_mode = 'edit';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('back');
        $this->addButton(
            'package_back',
            [
                'label' => __('Back'),
                'onclick' => "setLocation('" . $this->getBackUrl() . "')",
                'class' => 'back',
            ]
        );
    }

    /**
     * @return string
     */
    public function getBackUrl(): string {
        return $this->getUrl('norsys_package/package/index');
    }

}
