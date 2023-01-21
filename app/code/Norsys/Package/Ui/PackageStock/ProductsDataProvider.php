<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\PackageStock;
use Norsys\ProductStock\Model\ResourceModel\ProductStock\CollectionFactory;

class ProductsDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $productCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $productCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $productCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array {
        return [];
    }
}
