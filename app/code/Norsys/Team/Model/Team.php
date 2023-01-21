<?php

declare(strict_types=1);

namespace Norsys\Team\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Team extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'norsys_team';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_team';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Team\Model\ResourceModel\Team');
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

}
