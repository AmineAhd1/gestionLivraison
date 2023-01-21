<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Package;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ResponseInterface;
use Norsys\Package\Model\Package;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Result\PageFactory;
use Norsys\Package\Model\CrbtFactory;
use Norsys\Package\Model\PackageFactory;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;

/**
 * class Save
 *
 * @package   Norsys\Package\Controller\Adminhtml\Package
 * @category  class
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

    /** @var Session $authSession */
    protected Session $authSession;

    /** @var TimezoneInterface */
    protected TimezoneInterface $_date;

    /** * @var \Norsys\Package\Model\PackageTracking */
    protected $package_tracking;

    /** @var \Norsys\Package\Helper\ConfigurablePrice */
    protected \Norsys\Package\Helper\ConfigurablePrice $configurablePriceHelper;

    /** @var \Norsys\Package\Helper\GenerateUniquePackageCode */
    protected \Norsys\Package\Helper\GenerateUniquePackageCode $generateCodeHelper;

    /**
     * @param \Norsys\Package\Helper\ConfigurablePrice $configurablePriceHelper
     * @param \Norsys\Package\Helper\GenerateUniquePackageCode $generateCodeHelper
     * @param \Norsys\Package\Model\PackageTrackingFactory $package_tracking
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory
     * @param \Norsys\Package\Model\PackageTrackingFactory $packageTrackingFactory
     * @param \Norsys\Package\Model\PackageFactory $_packageFactory
     * @param \Norsys\Package\Model\CrbtFactory $_crbtFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     */
    public function __construct(
        \Norsys\Package\Helper\ConfigurablePrice             $configurablePriceHelper,
        \Norsys\Package\Helper\GenerateUniquePackageCode     $generateCodeHelper,
        \Norsys\Package\Model\PackageTrackingFactory         $package_tracking,
        \Magento\Backend\App\Action\Context                  $context,
        \Magento\Framework\View\Result\PageFactory           $resultPageFactory,
        PackageStatusFactory                                 $packageStatusFactory,
        PackageTrackingFactory                               $packageTrackingFactory,
        \Norsys\Package\Model\PackageFactory                 $_packageFactory,
        \Norsys\Package\Model\CrbtFactory                    $_crbtFactory,
        Session                                              $authSession,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    ) {
        parent::__construct($context);
        $this->_packageFactory = $_packageFactory;
        $this->_crbtFactory = $_crbtFactory;
        $this->_packageStatusFactory = $packageStatusFactory;
        $this->_packageTrackingFactory = $packageTrackingFactory;
        $this->authSession = $authSession;
        $this->_date = $date;
        $this->package_tracking = $package_tracking;
        $this->configurablePriceHelper = $configurablePriceHelper;
        $this->generateCodeHelper = $generateCodeHelper;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute() {
        /** @var String $packageStatus */
        $packageStatus = $this->getRequest()->getParam("packagestatus");
        if (isset($packageStatus)) {
            $packageTrackingFactory = $this->package_tracking->create();
            $packageTrackingFactory->setData('packageStatus_id', $this->getRequest()
                ->getParam('packagestatus'));
            $packageTrackingFactory->setData('package_id', $this->getRequest()
                ->getParam('id'));
            $packageTrackingFactory->save();
            $this->messageManager->addSuccess('package status updated successfully ');
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/manage');
        }
        $packageFactory = $this->_packageFactory->create();
        $crbtFactory = $this->_crbtFactory->create();
        /** @var String $statusId */
        $statusId = $this->_packageStatusFactory->create()->getCollection()
            ->addFieldToFilter('title', ['eq' => 'Pending'])
            ->getFirstItem()
            ->getData('packageStatus_id');
        /** @var \Norsys\Package\Model\PackageTracking $packageTrackingFactory */
        $packageTrackingFactory = $this->_packageTrackingFactory->create();
        /** @var String $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();
        $packageFactory->setData('receiverFullName', $this->getRequest()
            ->getParam('receiverFullName'));
        $packageFactory->setData('typePackage', 'Simple');
        $packageFactory->setData('phoneNumber', $this->getRequest()
            ->getParam('phoneNumber'));
        $packageFactory->setData('city', $this->getRequest()->getParam('city'));
        $packageFactory->setData('street', $this->getRequest()
            ->getParam('street'));
        $packageFactory->setData('zipCode', $this->getRequest()
            ->getParam('zipCode'));
        $packageFactory->setData('weight', $this->getRequest()
            ->getParam('weight'));
        /** @var String $code */
        $code = $this->generateCodeHelper->generatePackageCode();
        $packageFactory->setCode($code);
        /** @var int $deliveryPricePerOneKg */
        $deliveryPricePerOneKg = $this->configurablePriceHelper->getGeneralConfig("priceper1kg");
        $packageFactory->setData('price', $packageFactory->getWeight() * $deliveryPricePerOneKg);
        $packageFactory->setUserClId($connectedUserId);
        $crbtFactory->setData('status', $this->getRequest()
            ->getParam('status'));
        $crbtFactory->setData('price', $this->getRequest()
            ->getParam('priceCrbt'));
        if ($this->getRequest()->getParam('status') == 'Payed') {
            $crbtFactory->setData('paid_at', $this->_date->date()
                ->format('Y-m-d H:i:s'));
        }
        $packageFactory->save();
        /** @var String $packageId */
        $packageId = $packageFactory->getPackageId();
        $crbtFactory->setPackageId($packageId);
        $crbtFactory->save();
        $packageTrackingFactory->setData('packageStatus_id', $statusId);
        $packageTrackingFactory->setData('package_id', $packageId);
        $packageTrackingFactory->setData('created_at', $this->_date->date()
            ->format('Y-m-d H:i:s'));
        $packageTrackingFactory->save();
        $this->messageManager->addSuccess('Package have been saved.');
        $this->messageManager->addSuccess('You can use this code ' . $code . ' to track your package in our storefront');
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }

}
