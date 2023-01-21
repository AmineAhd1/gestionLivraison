<?php

namespace Norsys\Ticket\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class TicketAttachment extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'norsys_ticket_attachment';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_ticket_attachment';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Ticket\Model\ResourceModel\TicketAttachment');
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }


}
