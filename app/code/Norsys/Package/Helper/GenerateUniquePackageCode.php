<?php

declare(strict_types=1);

namespace Norsys\Package\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Norsys\Package\Model\PackageFactory;

/**
 * class GenerateUniquePackageCode
 *
 * @package   Norsys\Package\Helper
 * @category  class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class GenerateUniquePackageCode extends AbstractHelper {

    /**
     * @return string
     */
    public function generatePackageCode(): string {
        return substr(uniqid(), 0, 8);
    }

}
