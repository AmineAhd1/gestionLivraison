<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package\View;

use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\DataObject;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Norsys\Package\Model\CrbtFactory;
use Norsys\Package\Model\Package;
use Norsys\Package\Model\PackageFactory;
use Norsys\Package\Model\PackageProductStockFactory;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;
use Norsys\ProductStock\Model\ProductStockFactory;

class Info extends Widget {

    /** @var PackageFactory */
    protected PackageFactory $_packageFactory;

    /** @var CrbtFactory */
    protected CrbtFactory $_crbtFactory;

    /** @var PackageTrackingFactory */
    protected PackageTrackingFactory $_packageTrackingFactory;

    /** @var PackageStatusFactory */
    protected PackageStatusFactory $_packageStatusFactory;

    /** @var UserFactory */
    protected UserFactory $_userFactory;

    /** @var PackageProductStockFactory */
    protected PackageProductStockFactory $_packageProductStockFactory;

    /** @var ProductStockFactory */
    protected ProductStockFactory $_productStockFactory;

    /**
     * @param Context $context
     * @param PackageFactory $packageFactory
     * @param CrbtFactory $crbtFactory
     * @param PackageStatusFactory $packageStatusFactory
     * @param PackageTrackingFactory $packageTrackingFactory
     * @param UserFactory $userFactory
     * @param PackageProductStockFactory $packageProductStockFactory
     * @param ProductStockFactory $productStockFactory
     * @param array $data
     */
    public function __construct(
        Context                    $context,
        PackageFactory             $packageFactory,
        CrbtFactory                $crbtFactory,
        PackageStatusFactory       $packageStatusFactory,
        PackageTrackingFactory     $packageTrackingFactory,
        UserFactory                $userFactory,
        PackageProductStockFactory $packageProductStockFactory,
        ProductStockFactory        $productStockFactory,
        array                      $data = []
    ) {
        $this->_packageFactory = $packageFactory;
        $this->_crbtFactory = $crbtFactory;
        $this->_packageStatusFactory = $packageStatusFactory;
        $this->_packageTrackingFactory = $packageTrackingFactory;
        $this->_userFactory = $userFactory;
        $this->_packageProductStockFactory = $packageProductStockFactory;
        $this->_productStockFactory = $productStockFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return null|\Norsys\Package\Model\Package
     */
    public function getPackage(): ?Package {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageFactory->create()->load($packageId);
        }
        return NULL;
    }

    /**
     * @return \Magento\Framework\DataObject|null
     */
    public function getCRBT(): ?DataObject {
        if ($packageId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Package\Model\ResourceModel\Crbt\Collection $crbt */
            $crbt = $this->_crbtFactory->create()->getCollection();
            return $crbt->addFieldToFilter('package_id', ['eq' => $packageId])
                ->getLastItem();
        }
        return NULL;
    }

    /**
     * @return null|String
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPackageCreatedAt(): ?string {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageTrackingFactory->create()
                ->getCollection()
                ->addFieldToFilter('package_id', ['eq' => $packageId])
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                )
                ->setOrder('created_at', 'ASC')
                ->getFirstItem()
                ->getCreatedAt();
        }
        return NULL;
    }

    /**
     * @return null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTrackingStatus() {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageTrackingFactory->create()
                ->getCollection()
                ->addFieldToFilter('package_id', ['eq' => $packageId])
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                );
        }
        return NULL;
    }

    /**
     * @return null|String
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrentStatus(): ?string {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageTrackingFactory->create()
                ->getCollection()
                ->addFieldToFilter('package_id', ['eq' => $packageId])
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                )
                ->setOrder('created_at', 'DESC')
                ->getFirstItem()
                ->getTitle();
        }
        return NULL;
    }

    /**
     * @return \Magento\User\Model\User|null
     */
    public function getPackageUser(): ?User {
        if ($packageId = $this->getRequest()->getParam('id')) {
            if ($package = $this->_packageFactory->create()->load($packageId)) {
                /** @var string $userId */
                $userId = $package->getUserClId();
                return $this->_userFactory->create()->load($userId);
            }
        }
        return NULL;
    }

    /**
     * @return null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPackageProduct() {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageProductStockFactory->create()
                ->getCollection()
                ->addFieldToFilter('package_id', ['eq' => $packageId])
                ->join(
                    [
                        'productStock' => $this->_productStockFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.product_stock_id= productStock.entity_id'
                );
        }
        return NULL;
    }

}
