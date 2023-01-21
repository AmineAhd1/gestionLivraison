<?php

declare(strict_types=1);

namespace Norsys\Team\Block\Adminhtml\Team\View;

use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Context;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Norsys\Team\Model\TeamMemberFactory;
use Norsys\Team\Model\TeamFactory;

class Info extends Widget {

    /** @var TeamFactory */
    protected teamFactory $_teamFactory;

    /** @var TeamMemberFactory */
    protected TeamMemberFactory $_teamMemberFactory;

    /** @var UserFactory */
    protected UserFactory $_userFactory;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Norsys\Team\Model\TeamFactory $teamFactory
     * @param \Norsys\Team\Model\TeamMemberFactory $teamMemberFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param array $data
     */
    public function __construct(
        Context           $context,
        TeamFactory       $teamFactory,
        TeamMemberFactory $teamMemberFactory,
        UserFactory       $userFactory,
        array             $data = []
    ) {
        $this->_teamFactory = $teamFactory;
        $this->_teamMemberFactory = $teamMemberFactory;
        $this->_userFactory = $userFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Norsys\Team\Model\Team
     */
    public function getTeam() {
        /** @var string $teamId */
        $teamId = $this->getRequest()->getParam('id');
        return $this->_teamFactory->create()->load($teamId);
    }

    /**
     * @return \Magento\User\Model\User
     */
    public function getTeamUser(): User {
        /** @var string $teamId */
        $teamId = $this->getRequest()->getParam('id');
        /** @var \Norsys\Team\Model\Team $team */
        $team = $this->_teamFactory->create()->load($teamId);
        /** @var string $userId */
        $userId = $team->getUserClId();
        return $this->_userFactory->create()->load($userId);
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getMember() {
        /** @var string $teamId */
        $teamId = $this->getRequest()->getParam('id');
        $members = $this->_teamMemberFactory->create()->getCollection();
        return $members->addFieldToFilter('team_id', ['eq' => $teamId]);
    }

}
