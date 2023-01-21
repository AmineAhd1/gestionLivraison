<?php
declare(strict_types=1);

namespace Norsys\ProductStock\Model\ResourceModel;

class ProductStock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @return void
     */
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('norsys_product_stock_sl', 'entity_id');
    }
}
