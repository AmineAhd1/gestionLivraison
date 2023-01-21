<?php

declare(strict_types=1);

namespace Norsys\Package\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Crbt extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'norsys_crbt';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_crbt';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Package\Model\ResourceModel\Crbt');
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

}
