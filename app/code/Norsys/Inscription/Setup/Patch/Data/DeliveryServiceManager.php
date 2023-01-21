<?php
declare(strict_types=1);

namespace Norsys\Inscription\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class DeliveryServiceManager implements DataPatchInterface {

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
         * delivery service manager
         * description : Sous admin , qui a le privilège de gérer le service de livraison
         * (gestion des tickets , les colis …etc)
         */
        $role = $this->helper->createParentRole("delivery service manager");

        $resources = [
            "Magento_Backend::dashboard",
            "Norsys_Ticket::menu",
            "Norsys_Ticket::view",
            "Norsys_ProductStock::Stock",
            "Norsys_ProductStock::ManageStock",
            "Norsys_Team::team_management",
            "Norsys_Team::teams_manage",
            'Magento_Backend::system',
            'Magento_User::acl',
            'Magento_User::acl_users',
            'Magento_User::locks',
            'Magento_User::acl_roles',
            'Norsys_Package::Package',
            'Norsys_Package::packages_management',
            'Magento_Backend::stores',
            'Magento_Backend::stores_settings',
            'Magento_Config::config',
            'Norsys_Package::package_config'
        ];
        $this->helper->assignResourceToRole($role->getRoleId(), $resources);
    }

}
