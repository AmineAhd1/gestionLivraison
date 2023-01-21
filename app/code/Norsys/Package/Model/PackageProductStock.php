<?php

declare(strict_types=1);

namespace Norsys\Package\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class PackageProductStock extends AbstractModel implements IdentityInterface {

    const CACHE_TAG = 'norsys_package_productStock';

    /** @var string */
    protected $_eventPrefix = 'norsys_package_productStock';

    /**
     * @return void
     */
    public function _construct() {
        $this->_init('Norsys\Package\Model\ResourceModel\PackageProductStock');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
