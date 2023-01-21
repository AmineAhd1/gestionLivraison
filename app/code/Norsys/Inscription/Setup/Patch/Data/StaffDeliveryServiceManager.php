<?php
declare(strict_types=1);

namespace Norsys\Inscription\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class StaffDeliveryServiceManager implements DataPatchInterface {

    /**  * @var \Magento\Framework\Setup\ModuleDataSetupInterface */
    protected $moduleDataSetup;

    /** * @var \Norsys\Inscription\Helper\DataPatch */
    protected $helper;

    public function __construct(
        \Norsys\Inscription\Helper\DataPatch $helper,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->helper          = $helper;
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies() {
        return [
        ];
    }

    /**
     * @return array|string[]
     */
    public function getAliases() {
        return [];
    }

    public function apply() {
        /**
         * staff of the delivery service manager
         * sont des collaborateur , qui traitent comme exemple les tâches assigner ...etc
         */
        $role = $this->helper->createParentRole("staff of delivery service manager");

        $resources = [
            "Magento_Backend::dashboard",
            "Norsys_Task::task_management",
            "Norsys_Task::all_tasks",
        ];
        $this->helper->assignResourceToRole($role->getRoleId(), $resources);
    }

}
