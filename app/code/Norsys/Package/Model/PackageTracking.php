<?php

declare(strict_types=1);

namespace Norsys\Package\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class PackageTracking
 *
 * @package   Norsys\Package\Model
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class PackageTracking extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'norsys_packageTracking';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_packageTracking';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Norsys\Package\Model\ResourceModel\PackageTracking');
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array{
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

}


