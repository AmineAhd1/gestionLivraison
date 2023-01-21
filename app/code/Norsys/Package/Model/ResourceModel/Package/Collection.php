<?php

declare(strict_types=1);

namespace Norsys\Package\Model\ResourceModel\Package;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @var string $_idFieldName  */
    protected $_idFieldName = 'package_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_package_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\Package\Model\Package','Norsys\Package\Model\ResourceModel\Package');
    }

}
