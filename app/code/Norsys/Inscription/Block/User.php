<?php

declare(strict_types=1);

namespace Norsys\Inscription\Block;

use Magento\Backend\Block\Widget\Grid\Container;

class User extends Container {

    /**
     * @var \Magento\User\Model\ResourceModel\User
     */
    protected \Magento\User\Model\ResourceModel\User $_resourceModel;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\User\Model\ResourceModel\User $resourceModel
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context  $context,
        \Magento\User\Model\ResourceModel\User $resourceModel,
        array                                  $data = []
    ) {
        parent::__construct($context, $data);
        $this->_resourceModel = $resourceModel;
    }

    /**
     *
     * @return void
     */
    protected function _construct() {
        $this->addData(
            [
                \Magento\Backend\Block\Widget\Container::PARAM_CONTROLLER => 'user',
                Container::PARAM_BLOCK_GROUP => 'Norsys_Inscription',
                \Magento\Backend\Block\Widget\Container::PARAM_HEADER_TEXT => __('Inactive Customers of Delivery Service'),
            ]
        );
        parent::_construct();
        $this->buttonList->remove('add');
    }

}
