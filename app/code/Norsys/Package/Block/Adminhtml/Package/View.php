<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package;

use Magento\Authorization\Model\RoleFactory;
use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\UrlInterface;
use Magento\User\Model\UserFactory;
use Norsys\Package\Model\PackageFactory;

/**
 * Class View
 *
 * @package   Norsys\Package\Block\Adminhtml\Package
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class View extends Container {

    const ADMIN_RESOURCE_VIEW_PACKAGE = 'Norsys_Package::Packages';

    const ADMIN_RESOURCE_MANAGE_PACKAGE = 'Norsys_Package::packages_management';

    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /** @var string */
    protected $_blockGroup = 'Norsys_Package';

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Context      $context,
        UrlInterface $urlBuilder,
        array        $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _construct() {
        $this->_objectId = 'package_id';
        $this->_controller = 'adminhtml_package';
        $this->_mode = 'view';
        $this->addButton(
            'package_print',
            [
                'label' => __('Print invoice'),
                'onclick' => "setLocation('" . $this->getPrintUrl() . "')",
                'class' => 'print',
            ]
        );
        parent::_construct();
        if ($status = $this->getRequest()->getParam('status')) {
            $editStatusArray = ['Pending', 'Processing'];
            $resentStatusArray = ['Shipped', 'On The Way', 'Arrived'];
            $this->removeButton('delete');
            $this->removeButton('reset');
            $this->removeButton('save');
            $this->removeButton('back');
            if ($this->_isAllowedToViewPackages()) {
                $this->addButton(
                    'package_back',
                    [
                        'label' => __('Back'),
                        'onclick' => "setLocation('" . $this->getBackUrl() . "')",
                        'class' => 'back',
                    ]
                );
                if($status == 'Completed'){
                    $this->addButton(
                        'package_soft_delete',
                        [
                            'label' => __('Delete'),
                            'onclick' => "confirmSetLocation('Are you sure you want to delete this package ? ','{$this->getDeleteUrl() }')",
                            'class' => 'primary',
                        ]
                    );
                }
                if (in_array($status, $editStatusArray)) {
                    $this->addButton(
                        'package_edit',
                        [
                            'label' => __('Edit'),
                            'onclick' => "confirmSetLocation('Are you sure you want to edit this package ? ','{$this->getEditUrl()}')",
                            'class' => 'edit primary',
                        ]
                    );
                }
                if (in_array($status, $resentStatusArray)) {
                    $this->addButton(
                        'package_resent',
                        [
                            'label' => __('Resent'),
                            'onclick' => "confirmSetLocation('Are you sure you want to resent this package ? ','{$this->getEditUrl()}')",
                            'class' => 'edit primary',
                        ]
                    );
                }
            }
            elseif ($this->_isAllowedToManagePackages()) {
                $this->addButton(
                    'package_back',
                    [
                        'label' => __('Back'),
                        'onclick' => "setLocation('" . $this->getAdminBackUrl() . "')",
                        'class' => 'back',
                    ]
                );
            }
        }
    }

    /**
     * @return string
     */
    public function getEditUrl(): string {
        return $this->getUrl('norsys_package/packageresent/edit', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return string
     */
    public function getDeleteUrl(): string {
        return $this->getUrl('norsys_package/package/delete',[
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return string
     */
    public function getBackUrl(): string {
        return $this->getUrl('norsys_package/package/index');
    }

    /**
     * @return string
     */
    public function getAdminBackUrl(): string {
        return $this->getUrl('norsys_package/package/manage');
    }
    /**
     * @return string
     */
    public function getPrintUrl(): string {
        return $this->getUrl('norsys_package/invoice/printing', [
            'id' => $this->getRequest()
                ->getParam('id'),
        ]);
    }

    /**
     * @return bool
     */
    protected function _isAllowedToViewPackages(): bool {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE_VIEW_PACKAGE);
    }

    /**
     * @return bool
     */
    protected function _isAllowedToManagePackages(): bool {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE_MANAGE_PACKAGE);
    }

}
