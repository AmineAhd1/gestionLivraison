<?php

declare(strict_types=1);

namespace Norsys\Inscription\Model\ResourceModel\User;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init(\Magento\User\Model\User::class, \Magento\User\Model\ResourceModel\User::class);
    }

    /**
     * Collection Init Select
     *
     * @return $this
     * @since 101.1.0
     */
    protected function _initSelect() {
        parent::_initSelect();
        $this->getSelect()
            ->joinLeft(
                ['user_role' => $this->getTable('authorization_role')],
                'main_table.user_id = user_role.user_id AND user_role.parent_id != 0',
                []
            )
            ->joinLeft(
                ['detail_role' => $this->getTable('authorization_role')],
                'user_role.parent_id = detail_role.role_id',
                ['role_name']
            )
            ->where('detail_role.role_name = ?', 'customer of our delivery service')
            ->where('is_active = ?', 0);;
    }

}
