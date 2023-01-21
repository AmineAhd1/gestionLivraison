<?php

declare(strict_types=1);

namespace Norsys\Inscription\Block\User;

/**
 * User edit page
 *
 * @api
 * @author      Magento Core Team <core@magentocommerce.com>
 * @since 100.0.2
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container {

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = NULL;

    /** @var \Magento\Authorization\Model\RoleFactory $roleFactory */
    protected $roleFactory;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context    $context,
        \Magento\Framework\Registry              $registry,
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        array                                    $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->roleFactory = $roleFactory;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct() {
        $this->_objectId = 'user_id';
        $this->_controller = 'user';
        $this->_blockGroup = 'Magento_User';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save User'));
        $this->buttonList->remove('delete');

        $objId = (int) $this->getRequest()->getParam($this->_objectId);

        // Add Norsys
        /** @var string $roleID */
        $roleID = $this->roleFactory->create()->getCollection()
            ->addFieldToFilter('user_id', ['eq' => $objId])
            ->getFirstItem()
            ->getData('role_id');

        /** @var \Magento\Authorization\Model\Role\Interceptor $model */
        $model = $this->roleFactory->create()->load($roleID);

        /** @var string $parentId */
        $parentId = $model->getParentId();

        /** @var \Magento\Authorization\Model\Role\Interceptor $modelRole */
        $modelRole = $this->roleFactory->create()->load($parentId);

        /** @var string $roleName */
        $roleName = $modelRole->getRoleName();

        // Add Norsys

        if (!empty($objId)) {
            $this->addButton(
                'delete',
                [
                    'label' => __('Delete User'),
                    'class' => 'delete',
                    'data_attribute' => [
                        'role' => 'delete-user',
                    ],
                ]
            );
            // Add Norsys
            if ($roleName == 'customer of our delivery service') {
                $message = __('Are you sure you want to send an activation email to the user?');
                $this->addButton(
                    'send_email',
                    [
                        'label' => __('Send Activation Email'),
                        'onclick' => "confirmSetLocation('{$message}','{$this->getEmailUrl()}')",
                    ]
                );
                $message = __('Are you sure you want to send a rejection email to the user?');
                $this->addButton(
                    'send_rejection_email',
                    [
                        'label' => __('Send Rejection Email'),
                        'onclick' => "confirmSetLocation('{$message}','{$this->getRejectionEmailUrl()}')",
                    ]
                );
            }
            // Add Norsys
            $deleteConfirmMsg = __("Are you sure you want to revoke the user's tokens?");
            $this->addButton(
                'invalidate',
                [
                    'label' => __('Force Sign-In'),
                    'class' => 'invalidate-token',
                    'onclick' => "deleteConfirm('" . $this->escapeJs($this->escapeHtml($deleteConfirmMsg)) .
                        "', '" . $this->getInvalidateUrl() . "')",
                ]
            );
        }
    }

    /**
     * Returns message that is displayed for admin when he deletes user from
     * the system. To see this message admin must do the following:
     * - open user's account for editing;
     * - type current user's password in the "Current User Identity
     * Verification" field
     * - click "Delete User" at top left part of the page;
     *
     * @return \Magento\Framework\Phrase
     * @since 101.0.0
     */
    public function getDeleteMessage() {
        return __('Are you sure you want to do this?');
    }

    /**
     * Returns the URL that is used for user deletion.
     * The following Action is executed if admin navigates to returned url
     * Magento\User\Controller\Adminhtml\User\Delete
     *
     * @return string
     * @since 101.0.0
     */
    public function getDeleteUrl() {
        return $this->getUrl('adminhtml/*/delete');
    }

    /**
     * This method is used to get the ID of the user who's account the Admin is
     * editing. It can be used to determine the reason Admin opens the page: to
     * create a new user account OR to edit the previously created user account
     *
     * @return int
     * @since 101.0.0
     */
    public function getObjectId() {
        return (int) $this->getRequest()->getParam($this->_objectId);
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText() {
        if ($this->_coreRegistry->registry('permissions_user')->getId()) {
            $username = $this->escapeHtml($this->_coreRegistry->registry('permissions_user')
                ->getUsername());
            return __("Edit User '%1'", $username);
        }
        else {
            return __('New User');
        }
    }

    /**
     * Return validation url for edit form
     *
     * @return string
     */
    public function getValidationUrl() {
        return $this->getUrl('adminhtml/*/validate', ['_current' => TRUE]);
    }

    /**
     * Return invalidate url for edit form
     *
     * @return string
     */
    public function getInvalidateUrl() {
        return $this->getUrl('adminhtml/*/invalidatetoken', ['_current' => TRUE]);
    }

    // Add Norsys

    /**
     * @return string
     */
    public function getEmailUrl() {

        return $this->getUrl('adminhtml/*/email', [
            'user_id' => $this->getRequest()
                ->getParam('user_id'),
        ]);
    }

    /**
     * @return string
     */
    public function getRejectionEmailUrl() {
        return $this->getUrl('adminhtml/*/rejectionemail', [
            'user_id' => $this->getRequest()
                ->getParam('user_id'),
        ]);
    }

    // Add Norsys
}

