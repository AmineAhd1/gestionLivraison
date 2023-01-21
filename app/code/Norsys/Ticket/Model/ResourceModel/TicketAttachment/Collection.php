<?php

namespace Norsys\Ticket\Model\ResourceModel\TicketAttachment;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /** @var string $_idFieldName  */
    protected $_idFieldName = 'ticket_attachment_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_ticket_attachment_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\Ticket\Model\TicketAttachment','Norsys\Ticket\Model\ResourceModel\TicketAttachment');
    }

}
