<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\ProductStock;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\ProductStock\Model\ResourceModel\ProductStock\Collection;
use Norsys\ProductStock\Model\ResourceModel\ProductStock\CollectionFactory;

class ProductStockDataProvider extends AbstractDataProvider {

    /** * @var Collection $collection */
    protected $collection;

    /** * @var \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory */
    protected \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory;

    /** * @var Session $authSession */
    protected Session $authSession;

    /**
     * @param \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory
     * @param Session $authSession
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Norsys\ProductStock\Model\ResourceModel\Stock\CollectionFactory $_stockcollectionFactory,
        Session                                                          $authSession, $name, $primaryFieldName, $requestFieldName,
        CollectionFactory                                                $collectionFactory, array $meta = [],
        array                                                            $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->_stockcollectionFactory = $_stockcollectionFactory;
        $this->authSession = $authSession;
    }

    /**
     * @return AbstractCollection|Collection
     */
    public function getCollection() {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function getData() {

        /** @var string $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();

        /** @var  \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult $stockCollection */
        $stockCollection = $this->_stockcollectionFactory->create();

        /** @var  array $stockId */
        $stockId = $stockCollection->addFieldToFilter(
            'user_cl_id',
            ['eq' => $connectedUserId]
        )->toArray();

        return $this->getCollection()
            ->addFieldToFilter('stock_id', ['eq' => $stockId["items"][0]["entity_id"]])
            ->toArray();
    }

}
