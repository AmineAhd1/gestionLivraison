<?php

namespace Norsys\Ticket\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;


class CoreConfigData implements DataPatchInterface
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
        $table=$this->moduleDataSetup->getTable('core_config_data');
        $array = [
            [
                'path' => 'trans_email/ident_general/name',
                'value' => 'Trust Parcel'
            ],
            [
                'path' => 'trans_email/ident_general/email',
                'value' => 'trustparcelservice@gmail.com'
            ],
            [
                'path' => 'free/module/email',
                'value' => 'trustparcelservice@gmail.com'
            ],
            [
                'path' => 'free/module/name',
                'value' => 'Trust Parcel'
            ],
            [
                'path' => 'free/module/create',
                'value' => '1'
            ],
            [
                'path' => 'free/module/subscribe',
                'value' => '1'
            ],
            [
                'path' => 'smtp/module/active',
                'value' => '1'
            ],
            [
                'path' => 'smtp/module/product_key',
                'value' => '1LXSW383AMLZ4J01W07HHHXRTQ5U89ZVO19C4P4G'
            ],
            [
                'path' => 'smtp/module/email',
                'value' => 'trustparcelservice@gmail.com'
            ],
            [
                'path' => 'smtp/module/name',
                'value' => 'Trust Parcel'
            ],
            [
                'path' => 'smtp/module/create',
                'value' => '1'
            ],
            [
                'path' => 'smtp/module/subscribe',
                'value' => '1'
            ],
            [
                'path' => 'smtp/general/enabled',
                'value' => '1'
            ],
            [
                'path' => 'smtp/general/log_email',
                'value' => '1'
            ],
            [
                'path' => 'smtp/general/clean_email',
                'value' => '10'
            ],
            [
                'path' => 'smtp/configuration_option/host',
                'value' => 'smtp.gmail.com'
            ],
            [
                'path' => 'smtp/configuration_option/port',
                'value' => '465'
            ],
            [
                'path' => 'smtp/configuration_option/protocol',
                'value' => 'ssl'
            ],
            [
                'path' => 'smtp/configuration_option/authentication',
                'value' => 'login'
            ],
            [
                'path' => 'smtp/configuration_option/username',
                'value' => 'trustparcelservice@gmail.com'
            ],
            [
                'path' => 'smtp/configuration_option/password',
                'value' => '0:3:oPhuwv3L98HinNk2g7KOCxJkdxwit9Pq+1vujwmIyHbGAJj3kY/g3peZNg=='
            ],
            [
                'path' => 'smtp/configuration_option/test_email/from',
                'value' => 'general'
            ],
            [
                'path' => 'trans_email/ident_sales/email',
                'value' => 'trustparcelservice@gmail.com'
            ],
            [
                'path' => 'general/store_information/name',
                'value' => 'Trust Parcel'
            ],
            [
                'path' => 'trans_email/ident_support/email',
                'value' => 'trustparcelservice@gmail.com'
            ]
        ];
        $this->moduleDataSetup->getConnection()->insertArray($table,['path','value'],$array);
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
