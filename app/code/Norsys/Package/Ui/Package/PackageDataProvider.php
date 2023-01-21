<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\Package;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;
use Norsys\Package\Model\ResourceModel\Package\Collection;
use Norsys\Package\Model\ResourceModel\Package\CollectionFactory;
use Zend_Db_Expr;
use Norsys\Team\Model\TeamMemberFactory;
use Norsys\Team\Model\TeamFactory;

/**
 * class PackageDataProvider
 *
 * @package  Norsys\Package\Ui\Package
 * @category  class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class PackageDataProvider extends AbstractDataProvider {

    /** * @var Collection */
    protected $collection;

    /** * @var CollectionFactory */
    protected CollectionFactory $_packagecollectionFactory;

    /** * @var Session */
    protected Session $authSession;

    /** @var PackageStatusFactory */
    protected PackageStatusFactory $_packageStatusFactory;

    /** @var PackageTrackingFactory */
    protected PackageTrackingFactory $_packageTrackingFactory;

    /** @var TeamFactory */
    protected teamFactory $_teamFactory;

    /** @var TeamMemberFactory */
    protected TeamMemberFactory $_teamMemberFactory;

    /**
     * @param CollectionFactory $_packagecollectionFactory
     * @param Session $authSession
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param PackageStatusFactory $packageStatusFactory
     * @param \Norsys\Package\Model\PackageTrackingFactory $packageTrackingFactory
     * @param \Norsys\Team\Model\TeamFactory $teamFactory
     * @param \Norsys\Team\Model\TeamMemberFactory $teamMemberFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory      $_packagecollectionFactory,
        Session                $authSession, $name, $primaryFieldName, $requestFieldName,
        CollectionFactory      $collectionFactory,
        PackageStatusFactory   $packageStatusFactory,
        PackageTrackingFactory $packageTrackingFactory,
        TeamFactory            $teamFactory,
        TeamMemberFactory      $teamMemberFactory,
        array                  $meta = [],
        array                  $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->_packagecollectionFactory = $_packagecollectionFactory;
        $this->authSession = $authSession;
        $this->_packageStatusFactory = $packageStatusFactory;
        $this->_packageTrackingFactory = $packageTrackingFactory;
        $this->_teamFactory = $teamFactory;
        $this->_teamMemberFactory = $teamMemberFactory;
    }

    /**
     * @return AbstractCollection|\Norsys\Package\Model\ResourceModel\Package\Collection
     */
    public function getCollection() {
        return $this->collection;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData() {
        /** @var Zend_Db_Expr $query */
        $query = new \Zend_Db_Expr('(SELECT MAX(created_at) AS MaxDateTime from norsys_packageTracking
        GROUP BY package_id)');
        /** @var String $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();
        /** @var String $teamId */
        $teamId = $this->_teamFactory->create()->getCollection()
            ->addFieldToFilter('user_cl_id', ['eq' => $connectedUserId])
            ->getFirstItem()->getTeamId();
        /** @var array $teamMembers */
        $teamMembers = $this->_teamMemberFactory->create()->getCollection()
            ->addFieldToFilter('team_id', ['eq' => $teamId])
            ->addFieldToSelect('user_cl_id')->toArray();
        /** @var \Norsys\Package\Model\ResourceModel\PackageTracking\Collection $packageProductStockCollection */
        $packageProductStockCollection = $this->_packageTrackingFactory->create()
            ->getCollection();
        if ($teamId !== NULL and !empty($teamMembers['items'])) {
            $packageProductStockCollection->addFieldToFilter('user_cl_id', [
                'in' => [
                    $connectedUserId,
                    $teamMembers,
                ],
            ])
                ->getSelect()->where('created_at in' . $query)
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                )
                ->join(
                    [
                        'package' => $this->_packagecollectionFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.package_id= package.package_id'
                )->where('is_deleted = 0');
        }
        else {
            $packageProductStockCollection->addFieldToFilter('user_cl_id', ['eq' => $connectedUserId])
                ->getSelect()->where('created_at in' . $query)
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                )
                ->join(
                    [
                        'package' => $this->_packagecollectionFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.package_id= package.package_id'
                )->where('is_deleted = 0');
        }
        return $packageProductStockCollection->toArray();
    }

}
