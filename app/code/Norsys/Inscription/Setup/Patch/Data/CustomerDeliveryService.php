<?php
declare(strict_types=1);

namespace Norsys\Inscription\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class CustomerDeliveryService implements DataPatchInterface {

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
         * customer of our delivery service
         * Le client qui bénéficie de notre service de livraison
         */
        $role = $this->helper->createParentRole("customer of our delivery service");

        $resources = [
            "Magento_Backend::dashboard",
            "Norsys_ProductStock::Stock",
            "Norsys_ProductStock::ProductStock",
            "Norsys_Package::Package",
            "Norsys_Package::Packages",
            "Norsys_Team::team_management",
            "Norsys_Team::team_members",
        ];
        $this->helper->assignResourceToRole($role->getRoleId(), $resources);
    }

}
