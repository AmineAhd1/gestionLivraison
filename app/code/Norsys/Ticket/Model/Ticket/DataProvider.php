<?php

declare(strict_types=1);

namespace Norsys\Ticket\Model\Ticket;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\Ticket\Model\ResourceModel\Ticket\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $ticketCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $ticketCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $ticketCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $this->loadedData = array();
        foreach ($items as $ticket) {
            $this->loadedData[$ticket->getId()]['ticket'] = $ticket->getData();
        }
        return $this->loadedData;

    }

}
