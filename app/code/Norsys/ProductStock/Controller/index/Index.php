<?php

namespace Norsys\ProductStock\Controller\index;

use Magento\Framework\App\ResponseInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $_pageFactory;
    /** @var \Norsys\ProductStock\Model\ProductStockFactory */
    protected $_prodstockFactory;
    /** @var \Norsys\ProductStock\Model\StockFactory  */
    protected $stockFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context          $context,
        \Magento\Framework\View\Result\PageFactory     $pageFactory,
        \Norsys\ProductStock\Model\ProductStockFactory $prodstockFactory,
        \Norsys\ProductStock\Model\StockFactory $stock
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_prodstockFactory = $prodstockFactory;
        $this->stockFactory = $stock;
        return parent::__construct($context);
    }

    public function execute()
    {
        $prodStock = $this->_prodstockFactory->create();
        $stock = $this->stockFactory->create();
        //create stock
        $stock->setTitle("stock number 01 for sara");
        $stock->save();

        $prodStock->setTile("product for sara");
        $prodStock->setDescription("lorem lorem lorem lorem");
        $prodStock->setQty(10);
        $prodStock->setUnitPrice(100.56);
        $prodStock->setStockId(1);
        $prodStock->save();
        //create new product stock
        echo "ok";
    }
}
