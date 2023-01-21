<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\PackageStock;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\Package\Model\ResourceModel\Package\CollectionFactory;


class PackageStockDataProvider extends AbstractDataProvider {

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $packageCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $packageCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $packageCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        /** @var array $items */
        $items = $this->collection->getItems();

        $this->loadedData = [];
        $returnResult  = array(
            $this->collection->toArray(),
        );
        foreach ($items as $package) {

            $this->loadedData[$package->getId()]['packagestock'] = $this->collection->toArray();
        }


        return $this->loadedData;


    }

}
