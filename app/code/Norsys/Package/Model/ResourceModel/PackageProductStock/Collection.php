<?php

declare(strict_types=1);

namespace Norsys\Package\Model\ResourceModel\PackageProductStock;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    /** @var string */
    protected $_idFieldName = 'package_product_stock_id';

    /** @var string */
    protected $_eventPrefix = 'norsys_package_productStock_collection';

    /** @var string */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct() {
        $this->_init('Norsys\Package\Model\PackageProductStock', 'Norsys\Package\Model\ResourceModel\PackageProductStock');
    }

}
