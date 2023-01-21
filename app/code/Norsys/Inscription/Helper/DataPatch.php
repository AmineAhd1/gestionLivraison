<?php
declare(strict_types=1);

namespace Norsys\Inscription\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class DataPatch extends AbstractHelper {

    /** * @var \Magento\Authorization\Model\RoleFactory */
    protected $roleFactory;

    /** * @var \Magento\Authorization\Model\RulesFactory */
    protected $ruleFactory;

    public function __construct(
        \Magento\Authorization\Model\RulesFactory $ruleFactory,
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->roleFactory = $roleFactory;
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * @param string $roleName
     *
     * @return \Magento\Authorization\Model\Role
     * @throws \Exception
     */
    public function createParentRole(string $roleName) {
        $role = $this->roleFactory->create();
        $role->setRoleName($roleName);
        $role->setUserType("2");
        $role->setUserId(0);
        $role->setRoleType("G");
        $role->setSortOrder(0);
        $role->setTreeLevel(1);
        $role->setParentId(0);
        $role->save();
        return $role;
    }

    /**
     * @param $roleId
     * @param array $resources
     *
     * @return void
     */
    public function assignResourceToRole($roleId, array $resources) {
        $this->ruleFactory->create()
                          ->setRoleId($roleId)
                          ->setResources($resources)
                          ->saveRel();
    }

}
