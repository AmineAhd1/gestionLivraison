<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\Ticket;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Norsys\Team\Model\TeamFactory;
use Norsys\Team\Model\TeamMemberFactory;
use Norsys\Ticket\Model\ResourceModel\Ticket\Collection;
use Norsys\Ticket\Model\ResourceModel\Ticket\CollectionFactory;

class ViewReturnDataProvider extends AbstractDataProvider {

    /** * @var Collection $collection */
    protected $collection;

    /** * @var \Norsys\Ticket\Model\ResourceModel\Ticket\CollectionFactory $_ticketCollectionFactory */
    protected $_ticketCollectionFactory;

    /** * @var Session $authSession */
    protected $authSession;

    /** @var TeamFactory */
    protected teamFactory $_teamFactory;

    /** @var TeamMemberFactory */
    protected TeamMemberFactory $_teamMemberFactory;

    /**
     * @param \Norsys\Ticket\Model\ResourceModel\Ticket\CollectionFactory $_ticketCollectionFactory
     * @param Session $authSession
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Norsys\Ticket\Model\ResourceModel\Ticket\CollectionFactory $_ticketCollectionFactory,
        Session                                                     $authSession, $name, $primaryFieldName, $requestFieldName,
        CollectionFactory                                           $collectionFactory,
        TeamFactory                                                 $teamFactory,
        TeamMemberFactory                                           $teamMemberFactory,
        array                                                       $meta = [],
        array                                                       $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->_ticketCollectionFactory = $_ticketCollectionFactory;
        $this->authSession = $authSession;
        $this->_teamFactory = $teamFactory;
        $this->_teamMemberFactory = $teamMemberFactory;
    }

    /**
     * @return AbstractCollection|\Norsys\Ticket\Model\ResourceModel\Ticket\Collection
     */
    public function getCollection() {
        return $this->collection;
    }

    public function getData() {
        /** @var string $connectedUserId */
        $connectedUserId = $this->authSession->getUser()->getId();
        /** @var  \Norsys\Ticket\Model\ResourceModel\Ticket\Collection $ticketCollection */
        $ticketCollection = $this->_ticketCollectionFactory->create();
        /** @var String $teamId */
        $teamId = $this->_teamFactory->create()->getCollection()
            ->addFieldToFilter('user_cl_id', ['eq' => $connectedUserId])
            ->getFirstItem()->getTeamId();
        /** @var array $teamMembers */
        $teamMembers = $this->_teamMemberFactory->create()->getCollection()
            ->addFieldToFilter('team_id', ['eq' => $teamId])
            ->addFieldToSelect('user_cl_id')->toArray();
        if ($teamId !== NULL and !empty($teamMembers['items'])) {
            $ticketCollection->addFieldToFilter('user_cl_id', [
                'in' => [
                    $connectedUserId,
                    $teamMembers,
                ],
            ])->addFieldToFilter('type', ['eq' => 'Return Package']);
        }
        else {
            $ticketCollection->addFieldToFilter(
                'user_cl_id',
                ['eq' => $connectedUserId]
            )->addFieldToFilter('type', ['eq' => 'Return Package']);
        }
        return $ticketCollection->toArray();
    }

}
