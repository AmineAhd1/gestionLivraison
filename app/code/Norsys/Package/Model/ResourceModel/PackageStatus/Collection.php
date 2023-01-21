<?php

declare(strict_types=1);

namespace Norsys\Package\Model\ResourceModel\PackageStatus;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @var string $_idFieldName  */
    protected $_idFieldName = 'packageStatus_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_packageStatus_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\Package\Model\PackageStatus','Norsys\Package\Model\ResourceModel\PackageStatus');
    }

}
