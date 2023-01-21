<?php
declare(strict_types=1);

namespace Norsys\ProductStock\Model\ResourceModel;

class Stock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('norsys_stock_sl', 'entity_id');
    }
}
