<?php

declare(strict_types=1);

namespace Norsys\ProductStock\Block\Adminhtml\ProductStock\Stock\View;

use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Norsys\ProductStock\Model\ProductStockFactory;
use Norsys\ProductStock\Model\Stock;
use Norsys\ProductStock\Model\StockFactory;

class Info extends Widget
{
    /** @var StockFactory $_stockFactory*/
    protected StockFactory $_stockFactory;

    /** @var ProductStockFactory $_productStockFactory*/
    protected ProductStockFactory $_productStockFactory;

    /** @var UserFactory $_userFactory */
    protected UserFactory $_userFactory;

    /**
     * @param Context $context
     * @param StockFactory $stockFactory
     * @param ProductStockFactory $productStockFactory
     * @param UserFactory $userFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        StockFactory  $stockFactory,
        ProductStockFactory $productStockFactory,
        UserFactory $userFactory,
        array $data = []
    ) {
        $this->_stockFactory= $stockFactory;
        $this->_productStockFactory=$productStockFactory;
        $this->_userFactory = $userFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return Stock
     */
    public function getStock(): Stock
    {
        /** @var string $stockId */
        $stockId =$this->getRequest()->getParam('id');
        return $this->_stockFactory->create()->load($stockId);
    }

    /**
     * @return User
     */
    public function getStockUser(): User
    {
        /** @var string $stockId  */
        $stockId =$this->getRequest()->getParam('id');
        $stock=$this->_stockFactory->create()->load($stockId);
        /** @var string $userId */
        $userId=$stock->getUserClId();
        return $this->_userFactory->create()->load($userId);


    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getStockProduct()
    {
        /** @var string $stockId */
        $stockId=$this->getRequest()->getParam('id');
        $stockProduct=$this->_productStockFactory->create()->getCollection();
        return $stockProduct->addFieldToFilter('stock_id', array('eq' =>$stockId));
    }

}
