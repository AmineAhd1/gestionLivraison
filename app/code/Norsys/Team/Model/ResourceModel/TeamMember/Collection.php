<?php

declare(strict_types=1);

namespace Norsys\Team\Model\ResourceModel\TeamMember;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @var string $_idFieldName */
    protected $_idFieldName = 'team_member_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_team_member_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\Team\Model\TeamMember','Norsys\Team\Model\ResourceModel\TeamMember');
    }

}
