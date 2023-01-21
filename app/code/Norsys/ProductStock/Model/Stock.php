<?php
declare(strict_types=1);

namespace Norsys\ProductStock\Model;

class Stock extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'norsys_Stock';

    /** @var string $_cacheTag */
    protected $_cacheTag = 'norsys_Stock';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_Stock';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\ProductStock\Model\ResourceModel\Stock');
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        // TODO: Implement getIdentities() method.
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
