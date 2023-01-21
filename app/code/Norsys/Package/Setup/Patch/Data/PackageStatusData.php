<?php

namespace Norsys\Package\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;


class PackageStatusData implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup) {

        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [] ;
    }

    public function getAliases(): array
    {
        // TODO: Implement getAliases() method.
        return [] ;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $table=$this->moduleDataSetup->getTable('norsys_packageStatus');
        $array = [
            [
                'title' => 'Pending'
            ],
            [
                'title' => 'Processing'
            ],
            [
                'title' => 'Shipped'
            ],
            [
                'title' => 'On The Way'
            ],
            [
                'title' => 'Arrived'
            ],
            [
                'title' => 'Delivered'
            ],
            [
                'title' => 'Resent'
            ],
            [
                'title' => 'Returned'
            ],
            [
                'title' => 'Completed'
            ]
        ];
        $this->moduleDataSetup->getConnection()->insertArray($table,['title'],$array);
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
