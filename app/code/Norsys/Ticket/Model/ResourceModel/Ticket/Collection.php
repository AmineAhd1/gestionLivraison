<?php

declare(strict_types=1);

namespace Norsys\Ticket\Model\ResourceModel\Ticket;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @var string $_idFieldName  */
    protected $_idFieldName = 'ticket_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_ticket_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\Ticket\Model\Ticket','Norsys\Ticket\Model\ResourceModel\Ticket');
    }
}
