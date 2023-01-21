<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\PackageStock;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Norsys\Package\Helper\GenerateUniquePackageCode;
use Norsys\Package\Model\CrbtFactory;
use Norsys\Package\Model\PackageFactory;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;
use Norsys\ProductStock\Model\ProductStockFactory;
use Norsys\Package\Model\PackageProductStockFactory;

/**
 * class Form
 *
 * @package   Norsys\Package\Controller\Adminhtml\PackageStock
 * @category  class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Form extends \Magento\Backend\App\Action {

    /** @var \Norsys\ProductStock\Model\ProductStockFactory */
    protected ProductStockFactory $_productFactory;

    /** @var \Norsys\Package\Model\PackageProductStockFactory */
    protected $_packageProductStockFactory;

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

    /** @var bool|\Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory = FALSE;

    /** @var \Norsys\Package\Helper\ConfigurablePrice */
    protected $helper;

    /** @var \Norsys\Package\Helper\GenerateUniquePackageCode */
    protected GenerateUniquePackageCode $generateCodeHelper;

    /**
     * @param \Norsys\Package\Helper\ConfigurablePrice $helper
     * @param \Norsys\Package\Model\PackageTrackingFactory $package_tracking
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory
     * @param \Norsys\Package\Model\PackageTrackingFactory $packageTrackingFactory
     * @param \Norsys\Package\Model\PackageFactory $_packageFactory
     * @param \Norsys\Package\Model\CrbtFactory $_crbtFactory
     * @param \Norsys\ProductStock\Model\ProductStockFactory $_productFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Norsys\Package\Model\PackageProductStockFactory $_packageProductStockFactory
     * @param \Norsys\Package\Helper\GenerateUniquePackageCode $generateCodeHelper
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     */
    public function __construct(
        \Norsys\Package\Helper\ConfigurablePrice             $helper,
        \Norsys\Package\Model\PackageTrackingFactory         $package_tracking,
        \Magento\Backend\App\Action\Context                  $context,
        \Magento\Framework\View\Result\PageFactory           $resultPageFactory,
        PackageStatusFactory                                 $packageStatusFactory,
        PackageTrackingFactory                               $packageTrackingFactory,
        \Norsys\Package\Model\PackageFactory                 $_packageFactory,
        \Norsys\Package\Model\CrbtFactory                    $_crbtFactory,
        \Norsys\ProductStock\Model\ProductStockFactory       $_productFactory,
        Session                                              $authSession,
        PackageProductStockFactory                           $_packageProductStockFactory,
        GenerateUniquePackageCode                            $generateCodeHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    ) {
        parent::__construct($context);
        $this->generateCodeHelper = $generateCodeHelper;
        $this->_packageFactory = $_packageFactory;
        $this->_packageProductStockFactory = $_packageProductStockFactory;
        $this->_crbtFactory = $_crbtFactory;
        $this->_packageStatusFactory = $packageStatusFactory;
        $this->_packageTrackingFactory = $packageTrackingFactory;
        $this->authSession = $authSession;
        $this->_date = $date;
        $this->resultPageFactory = $resultPageFactory;
        $this->_productFactory = $_productFactory;
        $this->helper = $helper;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        /** @var \Norsys\Package\Model\PackageProductStockFactory $packageProductStockFactory */
        $packageProductStockFactory = $this->_packageProductStockFactory->create();

        /** @var \Norsys\Package\Model\Package $packageFactory */
        $packageFactory = $this->_packageFactory->create();

        /** @var \Norsys\Package\Model\Crbt $crbtFactory */
        $crbtFactory = $this->_crbtFactory->create();

        /** @var string $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();

        /** @var String $statusId */
        $statusId = $this->_packageStatusFactory->create()->getCollection()
            ->addFieldToFilter('title', ['eq' => 'Pending'])
            ->getFirstItem()
            ->getData('packageStatus_id');

        /** @var \Norsys\Package\Model\PackageTracking $packageTrackingFactory */
        $packageTrackingFactory = $this->_packageTrackingFactory->create();
        $packageData = $this->getRequest()->getParam('packagestock');

        if (is_array($packageData)) {
            try {
                /** @var string $productSelectQty */
                $productSelectQty = $packageData['quantity'];

                /** @var string $productID */
                $productID = $packageData['data']['product'];

                /** @var \Norsys\ProductStock\Model\ProductStock $productFactory */
                $productFactory = $this->_productFactory->create()
                    ->load($productID);

                /** @var string $productQty */
                $productQty = $productFactory->getData('qty');

                if ($productQty == 0) {
                    $this->messageManager->addErrorMessage('This product is Out of stock please select an other Product');
                    /** @var  \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('norsys_package/packagestock/form');
                }

                if ($productQty < $productSelectQty) {
                    $this->messageManager->addErrorMessage('Please select a quantity less than ' . $productQty . '');
                    /** @var  \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('norsys_package/packagestock/form');

                }

                $packageFactory->setData($packageData);
                $packageFactory->setData('typePackage', 'Stock');
                /** @var int $deliveryPricePerOneKg */
                $deliveryPricePerOneKg = $this->helper->getGeneralConfig("priceper1kg");
                $packageFactory->setData('price', $packageData['weight'] * $deliveryPricePerOneKg);
                /** @var String $code */
                $code = $this->generateCodeHelper->generatePackageCode();
                $packageFactory->setCode($code);
                $packageFactory->setUserClId($connectedUserId);
                $crbtFactory->setData('status', $packageData['status']);
                $productFactory->setData('qty', $productQty - $productSelectQty);
                $productPrice = $productFactory->getData('unitprice');
                if ($packageData['status'] == 'Payed') {
                    $crbtFactory->setData('paid_at', $this->_date->date()
                        ->format('Y-m-d H:i:s'));
                }
                else {
                    $crbtFactory->setData('price', $productPrice * $productSelectQty);
                }
                $productFactory->save();
                $packageFactory->save();
                /** @var string $packageId */
                $packageId = $packageFactory->getPackageId();
                $crbtFactory->setPackageId($packageId);
                $crbtFactory->save();
                $packageTrackingFactory->setData('packageStatus_id', $statusId);
                $packageTrackingFactory->setData('package_id', $packageId);
                $packageTrackingFactory->setData('created_at', $this->_date->date()
                    ->format('Y-m-d H:i:s'));
                $packageTrackingFactory->save();
                $packageProductStockFactory->setData('package_id', $packageId);
                $packageProductStockFactory->setData('product_stock_id', $productID);
                $packageProductStockFactory->setData('total_price', $productPrice * $productSelectQty);
                $packageProductStockFactory->setData('package_product_qty', $productSelectQty);
                $packageProductStockFactory->save();

                $this->messageManager->addSuccess('package has been saved.');
                $this->messageManager->addSuccess('You can use this code ' . $code . ' to track your package in our storefront');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
            /** @var  \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('norsys_package/packagestock/formproducts', ['packID' => $packageId]);
        }
    }

}
