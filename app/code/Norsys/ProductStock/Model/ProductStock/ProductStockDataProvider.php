<?php

declare(strict_types=1);

namespace Norsys\ProductStock\Model\ProductStock;

use Magento\Customer\Model\Customer;
use Norsys\ProductStock\Model\ResourceModel\ProductStock\CollectionFactory;

class ProductStockDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $productstockCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $productstockCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $productstockCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $productStock) {

            $this->loadedData[$productStock->getId()]['productStock'] = $productStock->getData();
        }
        return $this->loadedData;
    }

}
