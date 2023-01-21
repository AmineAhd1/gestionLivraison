<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\Component\Form\Product;

use Magento\Framework\Data\OptionSourceInterface;
use Norsys\ProductStock\Model\ResourceModel\ProductStock\CollectionFactory as ProductStockCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Norsys\ProductStock\Model\StockFactory;
use Magento\Backend\Model\Auth\Session;

class Options implements OptionSourceInterface {


    /** @var \Norsys\ProductStock\Model\StockFactory */
    protected StockFactory $_stockFactory;

    /** @var \Magento\Backend\Model\Auth\Session */
    protected Session $authSession;

    /** @var \Norsys\ProductStock\Model\ResourceModel\ProductStock\CollectionFactory  */
    protected ProductStockCollectionFactory $productstockCollectionFactory;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var array
     */
    protected $productTree;

    /**
     * @param \Norsys\ProductStock\Model\ResourceModel\ProductStock\CollectionFactory $productstockCollectionFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Norsys\ProductStock\Model\StockFactory $stockFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     */
    public function __construct(
        ProductStockCollectionFactory $productstockCollectionFactory,
        RequestInterface          $request,
        StockFactory        $stockFactory,
        Session             $authSession
    ) {
        $this->productstockCollectionFactory = $productstockCollectionFactory;
        $this->_stockFactory = $stockFactory;
        $this->authSession = $authSession;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array {
        return $this->getProductTree();
    }

    /**
     * @return array
     */
    protected function getProductTree(): array {
        /** @var string $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();

        /** @var  \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult $stockCollection */
        $stockCollection = $this->_stockFactory->create()->getCollection();

        /** @var \Magento\Framework\View\Element\UiComponent\DataProvider\Document $stock */
        $stock = $stockCollection->addFieldToFilter(
            'user_cl_id',
            ['eq' => $connectedUserId])->getFirstItem();

        /** @var string $stockId */
        $stockId = $stock->getEntityId();


        if ($this->productTree === NULL) {
            $products = $this->productstockCollectionFactory->create();

            $products->addFieldToFilter('stock_id', ['eq' => $stockId]);
            foreach ($products as $product) {
                $productId = $product->getEntityId();
                if (!isset($productById[$productId])) {
                    $productById[$productId] = [
                        'value' => $productId,
                    ];
                }
                $productById[$productId]['label'] = $product->getTitle();
            }
            $this->productTree = $productById;
        }
        return $this->productTree;
    }

}
