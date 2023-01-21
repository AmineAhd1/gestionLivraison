<?php

declare(strict_types=1);

namespace Norsys\Team\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class TeamMember extends AbstractModel implements IdentityInterface
{

    const CACHE_TAG = 'norsys_team_member';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_team_member';


    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Team\Model\ResourceModel\TeamMember');
    }


    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

}
