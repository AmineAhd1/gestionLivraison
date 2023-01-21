<?php

declare(strict_types=1);

namespace Norsys\Team\Block\Adminhtml\Team;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;

class View extends Container {

    /** @var \Magento\Framework\UrlInterface */
    protected UrlInterface $urlBuilder;

    /** @var string */
    protected $_blockGroup = 'Norsys_Team';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\UrlInterface $urlBuilder
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
     */
    protected function _construct() {
        $this->_objectId = 'team_id';
        $this->_controller = 'adminhtml_team';
        $this->_mode = 'view';
        parent::_construct();
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        $this->removeButton('back');
        $this->addButton(
            'team_back',
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
        return $this->getUrl('team/team/teamslist');
    }

}
