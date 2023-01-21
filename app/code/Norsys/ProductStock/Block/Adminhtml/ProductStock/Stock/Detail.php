<?php

declare(strict_types=1);

namespace Norsys\ProductStock\Block\Adminhtml\ProductStock\Stock;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class Detail extends Container
{
    /** @var UrlInterface $urlBuilder*/
    protected UrlInterface $urlBuilder;

    /** @var string $_blockGroup */
    protected $_blockGroup = 'Norsys_ProductStock';

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
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_productStock_stock';
        $this->_mode = 'view';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        $this->removeButton('back');
        $this->addButton(
            'stock_back',
            [
                'label' => __('Back'),
                'onclick' => "setLocation('" . $this->getBackUrl() . "')",
                'class' => 'back'
            ]
        );
    }
    /**
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('norsys_productstock/stock/stocklist');
    }
}
