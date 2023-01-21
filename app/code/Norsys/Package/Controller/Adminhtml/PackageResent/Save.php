<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\PackageResent;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Result\PageFactory;
use Norsys\Package\Helper\GenerateUniquePackageCode;
use Norsys\Package\Model\CrbtFactory;
use Norsys\Package\Model\PackageFactory;
use Norsys\Package\Model\PackageProductStockFactory;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;

/**
 * Class Save
 *
 * @package   Norsys\Package\Controller\Adminhtml\PackageResent
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Save extends Action {

    /** @var PackageFactory */
    protected PackageFactory $_packageFactory;

    /** @var CrbtFactory */
    protected CrbtFactory $_crbtFactory;

    /** @var PackageTrackingFactory */
    protected PackageTrackingFactory $_packageTrackingFactory;

    /** @var PackageStatusFactory */
    protected PackageStatusFactory $_packageStatusFactory;

    /** @var PackageProductStockFactory */
    protected PackageProductStockFactory $_packageProductStockFactory;

    /** @var Session $authSession */
    protected Session $authSession;

    /** @var TimezoneInterface */
    protected TimezoneInterface $_date;

    /** @var \Norsys\Package\Helper\GenerateUniquePackageCode  */
    protected GenerateUniquePackageCode $generateCodeHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Norsys\Package\Helper\GenerateUniquePackageCode $generateCodeHelper
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\Package\Model\PackageFactory $_packageFactory
     * @param \Norsys\Package\Model\CrbtFactory $_crbtFactory
     * @param \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory
     * @param \Norsys\Package\Model\PackageTrackingFactory $packageTrackingFactory
     * @param \Norsys\Package\Model\PackageProductStockFactory $packageProductStockFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     */
    public function __construct(
        Context                    $context,
        GenerateUniquePackageCode $generateCodeHelper,
        PageFactory                $resultPageFactory,
        PackageFactory             $_packageFactory,
        CrbtFactory                $_crbtFactory,
        PackageStatusFactory       $packageStatusFactory,
        PackageTrackingFactory     $packageTrackingFactory,
        PackageProductStockFactory $packageProductStockFactory,
        Session                    $authSession,
        TimezoneInterface          $date
    ) {
        parent::__construct($context);
        $this->generateCodeHelper= $generateCodeHelper;
        $this->_packageFactory = $_packageFactory;
        $this->_crbtFactory = $_crbtFactory;
        $this->_packageStatusFactory = $packageStatusFactory;
        $this->_packageTrackingFactory = $packageTrackingFactory;
        $this->_packageProductStockFactory = $packageProductStockFactory;
        $this->authSession = $authSession;
        $this->_date = $date;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Exception
     */
    public function execute() {
        /** @var array $packageData */
        if ($packageData = $this->getRequest()->getParams()) {
            /** @var array $editStatusArray */
            $editStatusArray = ['Pending', 'Processing'];
            if (in_array($packageData['title'], $editStatusArray)) {
                /** @var  \Norsys\Package\Model\Package $package */
                $package = $this->_packageFactory->create()
                    ->load($packageData['package_id']);
                $package->setData($packageData);
                $package->save();
                $this->messageManager->addSuccess('Package Address has been changed .');
            }
            else {
                /** @var \Norsys\Package\Model\Package $oldPackage */
                $oldPackage = $this->_packageFactory->create()
                    ->load($packageData['package_id']);

                /** @var \Norsys\Package\Model\Crbt $oldCrbt */
                $oldCrbt = $this->_crbtFactory->create()->getCollection()
                    ->addFieldToFilter('package_id', ['eq' => $packageData['package_id']])
                    ->getFirstItem();
                /** @var \Norsys\Package\Model\PackageTracking $oldPackageTracking */
                $oldPackageTracking = $this->_packageTrackingFactory->create()
                    ->load($packageData['packageTracking_id']);
                /** @var String $packageStatusId */
                $packageStatusId = $this->_packageStatusFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('title', ['eq' => 'Resent'])
                    ->getFirstItem()
                    ->getData('packageStatus_id');

                $oldPackageTracking->setData('packageStatus_id', $packageStatusId);
                $oldPackageTracking->save();
                /** @var  \Norsys\Package\Model\Package $newPackage */
                $newPackage = $this->_packageFactory->create();
                /** @var \Norsys\Package\Model\Crbt $newCrbt */
                $newCrbt = $this->_crbtFactory->create();
                $newPackage->setData('receiverFullName', $oldPackage->getData('receiverFullName'));
                $newPackage->setData('typePackage', $oldPackage->getData('typePackage'));
                $newPackage->setData('phoneNumber', $oldPackage->getData('phoneNumber'));
                $newPackage->setData('city', $packageData['city']);
                $newPackage->setData('street', $packageData['street']);
                $newPackage->setData('zipCode', $packageData['zipCode']);
                $newPackage->setData('weight', $oldPackage->getData('weight'));
                $newPackage->setData('price', $oldPackage->getData('price'));
                /** @var String $code */
                $code = $this->generateCodeHelper->generatePackageCode();
                $newPackage->setCode($code);
                $newPackage->setUserClId($oldPackage->getUserClId());
                $newPackage->setParentId($packageData['package_id']);
                $newPackage->save();
                $newCrbt->setData('status', $oldCrbt->getStatus());
                $newCrbt->setData('price', $oldCrbt->getPrice());
                $newCrbt->setData('paid_at', $oldCrbt->getPaidAt());
                /** @var String $newPackageId */
                $newPackageId = $newPackage->getPackageId();
                $newCrbt->setPackageId($newPackageId);
                $newCrbt->save();
                /** @var String $statusId */
                $statusId = $this->_packageStatusFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('title', ['eq' => 'Pending'])
                    ->getFirstItem()
                    ->getData('packageStatus_id');
                $packageTrackingFactory = $this->_packageTrackingFactory->create();
                $packageTrackingFactory->setData('packageStatus_id', $statusId);
                $packageTrackingFactory->setData('package_id', $newPackageId);
                $packageTrackingFactory->setData('created_at', $this->_date->date()
                    ->format('Y-m-d H:i:s'));
                $packageTrackingFactory->save();
                /** @var \Norsys\Package\Model\ResourceModel\PackageProductStock\Collection $packageProductStockCollection */
                $packageProductStockCollection = $this->_packageProductStockFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('package_id', ['eq' => $packageData['package_id']]);
                foreach ($packageProductStockCollection as $packageProductStock) {
                    $packageProductStock->setPackageId($newPackageId);
                    $packageProductStock->save();
                }
                $this->messageManager->addSuccess('Package has been Duplicated with different Address Information.');
                $this->messageManager->addSuccess('You can use this code ' . $code . ' to track the new package in our storefront');
            }
        }
        else {
            $this->messageManager->addErrorMessage('Resent Failed!! Try again');
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('norsys_package/package/index');
    }

}
