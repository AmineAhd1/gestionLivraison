<?php

declare(strict_types=1);

namespace Norsys\Package\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class PackageProductStock extends AbstractDb {

    /**
     * @param Context $context
     */
    public function __construct(Context $context) {
        parent::__construct($context);
    }

    /**
     * @return void
     */
    protected function _construct() {
        $this->_init('norsys_package_productStock', 'package_product_stock_id');
    }

}
