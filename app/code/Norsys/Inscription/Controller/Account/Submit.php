<?php
declare(strict_types=1);

namespace Norsys\Inscription\Controller\Account;


class Submit extends \Magento\Framework\App\Action\Action {

    /** @var \Magento\Framework\View\Result\PageFactory $pageFactory */
    protected $pageFactory;

    /** @var \Magento\User\Model\UserFactory $_userFactory */
    protected $_userFactory;

    /** @var \Norsys\ProductStock\Model\StockFactory $stockFactory */
    protected $stockFactory;

    /** @var \Norsys\Team\Model\TeamFactory $teamFactory */
    protected $teamFactory;

    /** @var \Magento\Authorization\Model\RoleFactory $roleFactory */
    protected $roleFactory;

    /**  * @var \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory */
    protected $roleCollectionFactory;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Norsys\ProductStock\Model\StockFactory $stockFactory
     * @param \Norsys\Team\Model\TeamFactory $teamFactory
     * @param \Magento\Authorization\Model\RoleFactory $roleFactory
     * @param \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $roleCollectionFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Norsys\ProductStock\Model\StockFactory $stockFactory,
        \Norsys\Team\Model\TeamFactory $teamFactory,
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $roleCollectionFactory
    ) {
        $this->stockFactory          = $stockFactory;
        $this->teamFactory           = $teamFactory;
        $this->_userFactory          = $userFactory;
        $this->pageFactory           = $pageFactory;
        $this->roleFactory           = $roleFactory;
        $this->roleCollectionFactory = $roleCollectionFactory;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $model = $this->_userFactory->create();
            $model->setFirstName($data["First_Name"]);
            $model->setLastName($data["Last_Name"]);
            $model->setUserName($data["UserName"]);
            $model->setEmail($data["email"]);
            $model->setPassword($data["Password"]);
            $model->setIsActive(0);
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__("Your request has been registered"));

                $stock = $this->stockFactory->create();
                $stock->setTitle($data["UserName"] . "'s stock");
                $stock->setUserClId($model->getUserId());
                $stock->save();

                $team = $this->teamFactory->create();
                $team->setName($data["UserName"] . "'s team");
                $team->setDescription("This is " . $data["First_Name"] . " " . $data["Last_Name"] . "'s team");
                $team->setUserClId($model->getUserId());
                $team->save();

                $role = $this->roleFactory->create();
                $role->setParentId($this->getAdminSlId()["items"][0]["role_id"]);
                $role->setTreeLevel(2);
                $role->setRoleType('U');
                $role->setUserId($model->getUserId());
                $role->setUserType('2');
                $role->setRoleName($data["First_Name"]);
                $role->save();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }
        return $this->_redirect('inscription/account/create');
    }

    /**
     * @return array
     */
    public function getAdminSlId() {
        return $this->roleCollectionFactory
            ->create()
            ->addFieldToFilter("role_name", ["eq" => "customer of our delivery service"])
            ->toArray();
    }

}
