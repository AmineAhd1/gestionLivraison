<?php
declare(strict_types=1);

namespace Norsys\Task\Ui\Task;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;

class TaskDataProvider extends AbstractDataProvider
{
    /** * @var \Norsys\Task\Model\ResourceModel\Task\CollectionFactory $_taskCollectionFactory */
    protected $_taskCollectionFactory;

    /**
     * @param \Norsys\Task\Model\ResourceModel\Task\CollectionFactory $_taskCollectionFactory
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Norsys\Task\Model\ResourceModel\Task\CollectionFactory $_taskCollectionFactory,
                                                                $name,
                                                                $primaryFieldName,
                                                                $requestFieldName,
        array                                                   $meta = [],
        array                                                   $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->_taskCollectionFactory = $_taskCollectionFactory->create();
    }

    /**
     * @return AbstractCollection|\Norsys\Task\Model\ResourceModel\Task\CollectionFactory
     */
    public function getCollection()
    {
        return $this->_taskCollectionFactory;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getCollection()
            ->toArray();
    }
}
