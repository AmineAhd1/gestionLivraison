<?php
declare(strict_types=1);

namespace Norsys\Team\Controller\adminhtml\Team;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\User\Model\UserFactory;
use Norsys\Team\Model\ResourceModel\TeamMember\CollectionFactory;
use Norsys\Team\Model\TeamMemberFactory;
use Magento\Authorization\Model\RoleFactory;

class Save extends \Magento\Backend\App\Action
{
    /**  * @var UserFactory $_userFactory */
    protected $_userFactory;
    /** * @var \Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamcollectionFactory */
    protected $_teamcollectionFactory;
    /** * @var Session $authSession */
    protected $authSession;
    /** * @var TeamMemberFactory $_teamMemberFactory */
    protected $_teamMemberFactory;
    /** * @var CollectionFactory $_teamMemberCollectionFactory */
    protected $_teamMemberCollectionFactory;
    /**  * @var RoleFactory $roleFactory */
    protected $roleFactory;
    /** * @var \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $_roleCollectionFactory */
    protected $_roleCollectionFactory;

    /**
     * @param \Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamcollectionFactory
     * @param CollectionFactory $_teamMemberCollectionFactory
     * @param TeamMemberFactory $_teamMemberFactory
     * @param Session $authSession
     * @param Action\Context $context
     * @param UserFactory $userFactory
     */
    public function __construct(
        \Norsys\Team\Model\ResourceModel\Team\CollectionFactory           $_teamcollectionFactory,
        CollectionFactory                                                 $_teamMemberCollectionFactory,
        TeamMemberFactory                                                 $_teamMemberFactory,
        Session                                                           $authSession,
        Action\Context                                                    $context,
        UserFactory                                                       $userFactory,
        RoleFactory                                                       $roleFactory,
        \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $_roleCollectionFactory
    )
    {
        $this->_userFactory = $userFactory;
        $this->_teamcollectionFactory = $_teamcollectionFactory;
        $this->_teamMemberFactory = $_teamMemberFactory;
        $this->_teamMemberCollectionFactory = $_teamMemberCollectionFactory;
        $this->roleFactory = $roleFactory;
        $this->_roleCollectionFactory = $_roleCollectionFactory;
        $this->authSession = $authSession;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        if (isset($this->getRequest()->getParams()["general"]["username"])) {
            if (
                $this->isValid(
                    $this->getRequest()->getParams()["general"]["password"],
                    $this->getRequest()->getParams()["general"]["confirmpassword"],
                    $this->getRequest()->getParams()["general"]["username"]
                )
            ) {
                $memberInfo = [
                    'username' => $this->getRequest()->getParams()["general"]["username"],
                    'firstname' => $this->getRequest()->getParams()["general"]["firstname"],
                    'lastname' => $this->getRequest()->getParams()["general"]["lastname"],
                    'email' => $this->getRequest()->getParams()["general"]["email"],
                    'password' => $this->getRequest()->getParams()["general"]["password"],
                    'interface_locale' => 'en_US',
                    'is_active' => 1
                ];
                $userModel = $this->_userFactory->create();
                $userModel->setData($memberInfo);
                try {
                    $userModel->save();
                    $connectedUserId = $this->authSession->getUser()->getId();;
                    $teamCollection = $this->_teamcollectionFactory->create();
                    $teamId = $teamCollection->addFieldToFilter(
                        'user_cl_id',
                        ['eq' => $connectedUserId]
                    )->toArray();
                    $teamId = $teamId["items"][0]["team_id"];
                    $teamMemberCollection = $this->_teamMemberFactory->create();
                    $teamMemberCollection->setTeamId($teamId);
                    $teamMemberCollection->setUserClId($userModel->getUserId());
                    $teamMemberCollection->setFirstname($this->getRequest()->getParams()["general"]["firstname"]);
                    $teamMemberCollection->setLastname($this->getRequest()->getParams()["general"]["lastname"]);
                    $teamMemberCollection->setEmail($this->getRequest()->getParams()["general"]["email"]);
                    $teamMemberCollection->setUsername($this->getRequest()->getParams()["general"]["username"]);
                    $teamMemberCollection->setPassword($userModel->getPassword());
                    $teamMemberCollection->save();

                    $roleModel = $this->roleFactory->create();
                    $roleModel->setRoleName($userModel->getFirstname());
                    $roleModel->setUserType("2");
                    $roleModel->setUserId($userModel->getUserId());
                    $roleModel->setRoleType("U");
                    $roleModel->setSortOrder(0);
                    $roleModel->setTreeLevel(2);
                    $staffCollection = $this->_roleCollectionFactory
                        ->create()
                        ->addFieldToFilter(
                            "role_name",
                            ["eq" => "staff of our customer of the delivery service"]
                        )
                        ->toArray();
                    $staffRoleId = $staffCollection["items"][0]["role_id"];
                    $roleModel->setParentId($staffRoleId);
                    $roleModel->save();

                    $this->messageManager->addSuccess(__('You have added new team member successfully.'));
                } catch (\Exception $ex) {
                    $this->messageManager->addError(__($ex->getMessage()));
                }
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('team/team/index', array('_current' => true));
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $data = $this->getRequest()->getParams();
            if (isset($data['team_member_id']) && $data['team_member_id']) {
                $model = $this->_teamMemberFactory->create()->load($data['team_member_id']);
                $model->setFirstname($data['firstname'])
                    ->setLastname($data['lastname'])
                    ->setEmail($data['email'])
                    ->setUsername($data['username']);
                $adminUserModel = $this->_userFactory->create()->load($model->getUserClId());
                $adminUserModel->setFirstname($data['firstname'])
                    ->setLastname($data['lastname'])
                    ->setEmail($data['email'])
                    ->setUsername($data['username']);
                if (strlen($data["newpassword"]) > 0) {
                    $adminUserModel->setPassword($data["newpassword"]);
                    $adminUserModel->save();
                    $model->setPassword($adminUserModel->getPassword());
                } else {
                    $adminUserModel->save();
                }
                $model->save();
                $this->messageManager->addSuccess(__('You have updated the team member successfully.'));
            }
            return $resultRedirect->setPath('team/team/index');
        }
    }

    /**
     * @param string $password
     * @param string $confirmPassword
     * @param string $username
     * @return bool
     */
    public function isValid(
        $password,
        $confirmPassword,
        $username
    )
    {
        $noErrors = 0;
        $collection = $this->_teamMemberCollectionFactory->create();
        $result = $collection->addFieldToFilter(
            'username',
            ['eq' => $username]
        )->toArray();
        if ($password != $confirmPassword) {
            $this->messageManager->addError(__('check your confirmation password , both has to be similar !'));
            $noErrors++;
        }
        if (count($result["items"]) > 0) {
            $this->messageManager->addError(__('user already exist !'));
            $noErrors++;
        }
        return !(($noErrors > 0));
    }
}
