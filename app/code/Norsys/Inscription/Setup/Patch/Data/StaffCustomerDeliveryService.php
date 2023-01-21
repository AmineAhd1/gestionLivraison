<?php
declare(strict_types=1);

namespace Norsys\Inscription\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class StaffCustomerDeliveryService implements DataPatchInterface {

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
         * staff of our customer of the delivery service
         * Staff du clients de notre service de livraison
         */
        $role = $this->helper->createParentRole("staff of our customer of the delivery service");

        $resources = [
            "Magento_Backend::dashboard",
        ];
        $this->helper->assignResourceToRole($role->getRoleId(), $resources);
    }

}
