<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\PackageStock;

use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Norsys\Package\Model\CrbtFactory;
use Norsys\ProductStock\Model\ProductStockFactory;
use Norsys\Package\Model\PackageProductStockFactory;

class FormProducts extends \Magento\Backend\App\Action {

    /** @var \Norsys\ProductStock\Model\ProductStockFactory */
    protected ProductStockFactory $_productFactory;

    /** @var \Norsys\Package\Model\PackageProductStockFactory */
    protected $_packageProductStockFactory;

    /** @var CrbtFactory */
    protected CrbtFactory $_crbtFactory;

    /** @var TimezoneInterface */
    protected TimezoneInterface $_date;

    /** @var bool|\Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory = FALSE;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\Package\Model\CrbtFactory $_crbtFactory
     * @param \Norsys\ProductStock\Model\ProductStockFactory $_productFactory
     * @param \Norsys\Package\Model\PackageProductStockFactory $_packageProductStockFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     */
    public function __construct(
        \Magento\Backend\App\Action\Context                  $context,
        \Magento\Framework\View\Result\PageFactory           $resultPageFactory,
        \Norsys\Package\Model\CrbtFactory                    $_crbtFactory,
        \Norsys\ProductStock\Model\ProductStockFactory       $_productFactory,
        PackageProductStockFactory                           $_packageProductStockFactory,

        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    ) {
        parent::__construct($context);
        $this->_crbtFactory = $_crbtFactory;
        $this->_date = $date;
        $this->resultPageFactory = $resultPageFactory;
        $this->_packageProductStockFactory = $_packageProductStockFactory;
        $this->_productFactory = $_productFactory;
    }

    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        /** @var \Norsys\Package\Model\PackageProductStockFactory $packageProductStockFactory */
        $packageProductStockFactory = $this->_packageProductStockFactory->create();

        /** @var array $packageData */
        $packageData = $this->getRequest()->getParam('general');

        /** @var string $packageID */
        $packageID = $this->getRequest()->getParam('packID');
        if (is_array($packageData)) {
            try {
                /** @var string $crbtID */
                $crbtID = $this->_crbtFactory->create()->getCollection()
                    ->addFieldToFilter('package_id', ['eq' => $packageID])
                    ->getFirstItem()
                    ->getData('crbt_id');
                /** @var \Norsys\Package\Model\Crbt $crbtFactory */
                $crbtFactory = $this->_crbtFactory->create()->load($crbtID);

                /** @var string $productID */
                $productID = $packageData['data']['product'];

                /** @var string $productSelectQty */
                $productSelectQty = $packageData['quantity'];

                /** @var \Norsys\ProductStock\Model\ProductStock $productFactory */
                $productFactory = $this->_productFactory->create()
                    ->load($productID);

                /** @var string $productQty */
                $productQty = $productFactory->getData('qty');

                if ($productQty == 0) {
                    $this->messageManager->addErrorMessage('This product is Out of stock please select an other Product');
                    /** @var  \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('norsys_package/packagestock/formproducts', ['packID' => $packageID]);
                }
                if ($productQty < $productSelectQty) {
                    $this->messageManager->addErrorMessage('Please select a quantity less than ' . $productQty . '');
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('norsys_package/packagestock/formproducts', ['packID' => $packageID]);

                }
                $productFactory->setData('qty', $productQty - $productSelectQty);
                $productPrice = $productFactory->getData('unitprice');
                $productFactory->save();
                if ($crbtFactory->getData('status') != 'Payed') {
                    $totalprice = $crbtFactory->getData('price');
                    $crbtFactory->setData('price', $totalprice + ($productPrice * $productSelectQty));
                    $crbtFactory->save();
                }
                /** @var  string $packageProductStockID */
                $packageProductStockID = $this->_packageProductStockFactory->create()
                    ->getCollection()
                    ->addFieldToFilter('product_stock_id', ['eq' => $productID])
                    ->addFieldToFilter('package_id', ['eq' => $packageID])
                    ->getFirstItem()
                    ->getData('package_product_stock_id');
                /** @var \Norsys\Package\Model\PackageProductStock $prodPackFactory */
                $prodPackFactory = $this->_packageProductStockFactory->create()
                    ->load($packageProductStockID);

                if (!empty($prodPackFactory->getData('package_product_stock_id'))) {
                    /** @var string $prodPackPrice */
                    $prodPackPrice = $prodPackFactory->getData('total_price');
                    /** @var string $prodPackQty */
                    $prodPackQty = $prodPackFactory->getData('package_product_qty');
                    $prodPackFactory->setData('total_price', $prodPackPrice + ($productPrice * $productSelectQty));
                    $prodPackFactory->setData('package_product_qty', $prodPackQty + $productSelectQty);
                    $prodPackFactory->save();
                }
                else {
                    $packageProductStockFactory->setData('package_id', $packageID);
                    $packageProductStockFactory->setData('product_stock_id', $productID);
                    $packageProductStockFactory->setData('total_price', $productPrice * $productSelectQty);
                    $packageProductStockFactory->setData('package_product_qty', $productSelectQty);
                    $packageProductStockFactory->save();
                }

                $this->messageManager->addSuccess('product has been added to package.');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
            /** @var  \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('norsys_package/packagestock/formproducts', ['packID' => $packageID]);
        }
    }


}
