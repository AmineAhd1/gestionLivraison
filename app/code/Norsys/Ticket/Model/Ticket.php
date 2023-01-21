<?php

declare(strict_types=1);

namespace Norsys\Ticket\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Ticket extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'norsys_ticket';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_ticket';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Ticket\Model\ResourceModel\Ticket');
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

}
