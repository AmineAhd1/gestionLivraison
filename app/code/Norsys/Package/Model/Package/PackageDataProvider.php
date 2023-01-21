<?php

declare(strict_types=1);

namespace Norsys\Package\Model\Package;

use Magento\Customer\Model\Customer;
use Norsys\Package\Model\ResourceModel\Package\CollectionFactory;

class PackageDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
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
        foreach ($items as $package) {
            $this->loadedData[$package->getId()]['package'] = $package->getData();
        }
        return $this->loadedData;
    }

}
