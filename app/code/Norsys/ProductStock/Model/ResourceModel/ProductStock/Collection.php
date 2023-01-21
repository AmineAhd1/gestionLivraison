<?php
declare(strict_types=1);

namespace Norsys\ProductStock\Model\ResourceModel\ProductStock;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /** @var string $_idFieldName */
    protected $_idFieldName = 'entity_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_productstock_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'productstock_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\ProductStock\Model\ProductStock', 'Norsys\ProductStock\Model\ResourceModel\ProductStock');
    }
}
