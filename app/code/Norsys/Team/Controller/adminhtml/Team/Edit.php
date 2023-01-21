<?php
declare(strict_types=1);

namespace Norsys\Team\Controller\adminhtml\Team;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Edit extends \Magento\Backend\App\Action
{
    /** * @var \Magento\Framework\Registry $coreRegistry */
    private $coreRegistry;
    /** * @var \Norsys\Team\Model\TeamMemberFactory $_teamMemberFactory */
    private $_teamMemberFactory;

    /**
     * @param Action\Context $context
     * @param \Norsys\Team\Model\TeamMemberFactory $_teamMemberFactory
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        Action\Context                        $context,
        \Norsys\Team\Model\TeamMemberFactory $_teamMemberFactory,
        \Magento\Framework\Registry           $coreRegistry
    )
    {
        parent::__construct($context);
        $this->_teamMemberFactory = $_teamMemberFactory;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $rowId = (int)$this->getRequest()->getParam('id');
        $rowData = $this->_teamMemberFactory->create()->load($rowId);
        $this->coreRegistry->register('selectedMember', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Team Member ') : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Norsys_Team::team_management');
    }
}
