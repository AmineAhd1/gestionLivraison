<?php
declare(strict_types=1);

namespace Norsys\Package\Ui\Package;

use Magento\Backend\Model\Auth\Session;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\Package\Model\ResourceModel\Package\CollectionFactory;

/**
 * class ManagePackageDataProvider
 *
 * @package  Norsys\Package\Ui\Package
 * @category  class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class ManagePackageDataProvider extends AbstractDataProvider {

    /** * @var Session $authSession */
    protected $authSession;

    /** * @var \Norsys\Package\Model\PackageFactory */
    protected $package_factory;

    /**  * @var \Norsys\Package\Model\CrbtFactory */
    protected $crbt_factory;

    /** * @var CollectionFactory */
    protected $collection;

    /**
     * @param \Norsys\Package\Model\PackageFactory $package_factory
     * @param \Norsys\Package\Model\CrbtFactory $crbt_factory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Norsys\Package\Model\PackageFactory $package_factory,
        \Norsys\Package\Model\CrbtFactory $crbt_factory,
        Session $authSession, $name, $primaryFieldName, $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->authSession     = $authSession;
        $this->package_factory = $package_factory;
        $this->crbt_factory    = $crbt_factory;
        $this->collection      = $package_factory->create();
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData() {
        $package     = $this->package_factory->create()
                                             ->getResource()
                                             ->getMainTable();
        $crbtFactory = $this->crbt_factory->create()->getCollection();
        $crbtFactory->getSelect()
                    ->join(
                        ['package' => $package],
                        "main_table.package_id = package.package_id"
                    )->where('is_deleted = 0');
        return $crbtFactory->toArray();
    }

}
