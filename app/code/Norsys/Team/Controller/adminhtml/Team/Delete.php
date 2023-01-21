<?php
declare(strict_types=1);

namespace Norsys\Team\Controller\adminhtml\Team;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Norsys\Team\Model\ResourceModel\Team\CollectionFactory;

class Delete extends Action
{
    /** * @var bool|\Magento\Framework\View\Result\PageFactory $resultPageFactory */
    protected $resultPageFactory = false;
    /** * @var \Norsys\Team\Model\TeamMemberFactory $_teamMemberFactory */
    protected $_teamMemberFactory;
    /** * @var \Magento\User\Model\UserFactory $_userFactory */
    protected $_userFactory;
    /**  * @var \Magento\Ui\Component\MassAction\Filter $_filter */
    protected $_filter;
    /** * @var CollectionFactory $_teamCollectionFactory */
    protected $_teamCollectionFactory;

    /**
     * @param CollectionFactory $_teamCollectionFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\Team\Model\TeamMemberFactory $_teamMemberFactory
     * @param \Magento\User\Model\UserFactory $_userFactory
     */
    public function __construct(
        \Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamCollectionFactory,
        \Magento\Ui\Component\MassAction\Filter                 $filter,
        \Magento\Backend\App\Action\Context                     $context,
        \Magento\Framework\View\Result\PageFactory              $resultPageFactory,
        \Norsys\Team\Model\TeamMemberFactory                    $_teamMemberFactory,
        \Magento\User\Model\UserFactory                         $_userFactory
    )
    {
        parent::__construct($context);
        $this->_filter = $filter;
        $this->_teamCollectionFactory = $_teamCollectionFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_userFactory = $_userFactory;
        $this->_teamMemberFactory = $_teamMemberFactory;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        try {
            $selectedTeamMember = $this->_teamMemberFactory->create()
                ->load($this->getRequest()->getParam("id"));
            $adminUserId = $selectedTeamMember->getUserClId();
            $adminUser = $this->_userFactory->create()
                ->load($adminUserId)
                ->delete();
            $selectedTeamMember->delete();
            $this->messageManager->addSuccess(__('You have deleted your team member successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('team/team/index', array('_current' => true));
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Norsys_Team::team_management');
    }
}
