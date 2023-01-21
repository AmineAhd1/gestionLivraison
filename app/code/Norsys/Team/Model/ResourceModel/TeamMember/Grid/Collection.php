<?php
declare(strict_types=1);

namespace Norsys\Team\Model\ResourceModel\TeamMember\Grid;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Psr\Log\LoggerInterface as Logger;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Event\ManagerInterface as EventManager;

class Collection extends SearchResult
{
    /**
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param $resourceModel
     * @throws LocalizedException
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger        $logger,
        FetchStrategy $fetchStrategy,
        EventManager  $eventManager,
                      $mainTable = "norsys_team_member",
                      $resourceModel = "Norsys\Team\Model\ResourceModel\TeamMember"
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager,
            $mainTable, $resourceModel);
    }

}
