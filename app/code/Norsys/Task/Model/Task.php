<?php
declare(strict_types=1);

namespace Norsys\Task\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Task extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'norsys_task';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_task';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Task\Model\ResourceModel\Task');
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

}
