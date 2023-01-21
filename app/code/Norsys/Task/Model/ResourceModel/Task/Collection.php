<?php
declare(strict_types=1);
namespace Norsys\Task\Model\ResourceModel\Task;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /** @var string $_idFieldName  */
    protected $_idFieldName = 'task_id';

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'norsys_task_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'norsys_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Norsys\Task\Model\Task','Norsys\Task\Model\ResourceModel\Task');
    }
}
