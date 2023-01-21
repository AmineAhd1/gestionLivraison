<?php

declare(strict_types=1);

namespace Norsys\ProductStock\Controller\Adminhtml\Stock;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Norsys\ProductStock\Model\ProductStock;
use Magento\Backend\Model\Auth\Session;


class NewProductStock extends Action
{
    /** @var \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory */
    
    protected $_stockcollectionFactory;

    /** @var Session $authSession */
    protected $authSession;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory
     * @param Session $authSession
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory,
        Session $authSession
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->authSession = $authSession;
        $this->_stockcollectionFactory = $_stockcollectionFactory;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
        $productStockDatas = $this->getRequest()->getParam('productStock');
        if (is_array($productStockDatas)) {
            $productStock = $this->_objectManager->create(ProductStock::class);
            $stockCollection = $this->_stockcollectionFactory->create();
            $connectedUserId = $this->authSession->getUser()->getId();
            $productStock->setData($productStockDatas);
            $stockId = $stockCollection->addFieldToFilter(
                'user_cl_id',
                ['eq' => $connectedUserId]
            )->toArray();
            $productStock->setTitle($productStockDatas["title"]);
            $productStock->setDescription($productStockDatas["description"]);
            $productStock->setQty($productStockDatas["qty"]);
            $productStock->setUnitprice($productStockDatas["unitprice"]);
            $productStock->setStockId($stockId["items"][0]["entity_id"]);
            $productStock->save();
            $this->messageManager->addSuccess('record have been saved.');
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index');
        }
    }

}
