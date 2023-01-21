<?php

declare(strict_types=1);

namespace Norsys\ProductStock\Controller\Adminhtml\Stock;

use Magento\Backend\App\Action\Context;
use Norsys\ProductStock\Model\ProductStockFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /** @var ProductStockFactory $_productstockFactory */
    protected $_productstockFactory;

    /**
     * @param Context $context
     * @param ProductStockFactory $productstockFactory
     */
    public function __construct(
        Context                                    $context,
        ProductStockFactory                        $productstockFactory
    )
    {
        $this->_productstockFactory = $productstockFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $productModel = $this->_productstockFactory->create();
            $productModel->load($id);
            $productModel->delete();
            $this->messageManager->addSuccessMessage(__('record have been deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/index', array('_current' => true));

    }

    /**
     * Summary of _isAllowed
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Norsys_ProductStock::ProductStock');
    }

}
