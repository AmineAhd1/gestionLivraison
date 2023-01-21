<?php

declare(strict_types=1);

namespace Norsys\Package\Model\ResourceModel\PackageTracking;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package   Norsys\Package\Model\ResourceModel\PackageTracking
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Collection extends AbstractCollection {

    /** @var string $_idFieldName */
    protected $_idFieldName = 'packageTracking_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_packageTracking_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /** @var \Magento\Framework\DB\Helper */
    protected \Magento\Framework\DB\Helper $_coreResourceHelper;

    /** @var \Norsys\Package\Model\PackageFactory */
    protected \Norsys\Package\Model\PackageFactory $_packageFactory;

    /** @var \Norsys\Package\Model\PackageStatusFactory */
    protected \Norsys\Package\Model\PackageStatusFactory $_packageStatusFactory;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\DB\Helper $coreResourceHelper
     * @param \Norsys\Package\Model\PackageFactory $packageFactory
     * @param \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory             $entityFactory,
        \Psr\Log\LoggerInterface                                     $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface                    $eventManager,
        \Magento\Framework\DB\Helper                                 $coreResourceHelper,
        \Norsys\Package\Model\PackageFactory                         $packageFactory,
        \Norsys\Package\Model\PackageStatusFactory                   $packageStatusFactory,
        \Magento\Framework\DB\Adapter\AdapterInterface               $connection = NULL,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb         $resource = NULL

    ) {
        $this->_packageFactory = $packageFactory;
        $this->_packageStatusFactory = $packageStatusFactory;
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_coreResourceHelper = $coreResourceHelper;
    }

    /**
     * @return void
     */
    protected function _construct() {
        $this->_init('Norsys\Package\Model\PackageTracking', 'Norsys\Package\Model\ResourceModel\PackageTracking');
    }

    /**
     * @param string $packageCode
     *
     * @return \Norsys\Package\Model\ResourceModel\PackageTracking\Collection|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTrackingStatus(string $packageCode): ?Collection {
        /** @var String $packageId */
        $packageId = $this->_packageFactory->create()->getCollection()
            ->addFieldToFilter('code', ['eq' => $packageCode])
            ->getFirstItem()
            ->getPackageId();
        if (isset($packageId)) {
            try {
                /** @var Collection $trackingStatus */
                $trackingStatus = $this->addFieldToFilter('package_id', ['eq' => $packageId])
                    ->join(
                        [
                            'status' => $this->_packageStatusFactory->create()
                                ->getResource()
                                ->getMainTable(),
                        ],
                        'main_table.packageStatus_id= status.packageStatus_id'
                    );
                return $trackingStatus;
            } catch (\Exception $e) {
                $this->_logger->critical($e->getMessage());
            }
        }
        return NULL;
    }

}
