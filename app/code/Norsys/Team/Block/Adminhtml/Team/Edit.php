<?php
declare(strict_types=1);
namespace Norsys\Team\Block\Adminhtml\Team;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Model\UrlInterface;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /** * @var UrlInterface $_backendUrl  */
    protected $_backendUrl;

    /**
     * @param UrlInterface $backendUrl
     * @param Context $context
     * @param array $data
     */
    public function __construct(UrlInterface $backendUrl, Context $context, array $data = [])
    {
        $this->_backendUrl = $backendUrl;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Norsys_Team';
        $this->_controller = 'Adminhtml_Team';
        parent::_construct();
        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');
    }

}
