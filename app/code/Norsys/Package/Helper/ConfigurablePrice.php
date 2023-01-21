<?php
declare(strict_types=1);

namespace Norsys\Package\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * class ConfigurablePrice
 *
 * @package   Norsys\Package\Helper
 * @category  class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class ConfigurablePrice extends AbstractHelper {

    /** @const string */
    const SECTION = "packages_conf/";

    /** @const string */
    const CONFIG_GROUP = "package_items_group/";

    /**
     * @param $field
     * @param $storeId
     *
     * @return mixed
     */
    public function getConfigValue($field, $storeId = NULL) {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param $code
     * @param $storeId
     *
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = NULL) {
        return $this->getConfigValue(self::SECTION . self::CONFIG_GROUP . $code, $storeId);
    }

}
