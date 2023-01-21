<?php
declare(strict_types=1);

namespace Norsys\Team\Ui\TeamMember;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\Team\Model\ResourceModel\TeamMember\Collection;
use Norsys\Team\Model\ResourceModel\TeamMember\CollectionFactory;

class TeamMemberDataProvider extends AbstractDataProvider
{
    /** * @var Collection $collection */
    protected $collection;
    /** * @var \Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamcollectionFactory */
    protected $_teamcollectionFactory;
    /** * @var Session $authSession */
    protected $authSession;

    /**
     * @param \Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamcollectionFactory
     * @param Session $authSession
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamcollectionFactory,
        Session                                                 $authSession,
                                                                $name,
                                                                $primaryFieldName,
                                                                $requestFieldName,
        CollectionFactory                                       $collectionFactory,
        array                                                   $meta = [],
        array                                                   $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->_teamcollectionFactory = $_teamcollectionFactory;
        $this->authSession = $authSession;
    }

    /**
     * @return AbstractCollection|Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $connectedUserId = $this->authSession->getUser()->getId();;
        $teamCollection = $this->_teamcollectionFactory->create();
        $teamId = $teamCollection->addFieldToFilter(
            'user_cl_id',
            ['eq' => $connectedUserId]
        )->toArray();
        return $this->getCollection()
            ->addFieldToFilter('team_id', ['eq' => $teamId["items"][0]["team_id"]])
            ->toArray();
    }
}
