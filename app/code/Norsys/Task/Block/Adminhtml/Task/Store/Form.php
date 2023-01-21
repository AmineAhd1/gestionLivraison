<?php
declare(strict_types=1);

namespace Norsys\Task\Block\Adminhtml\Task\Store;

use Magento\Framework\Exception\LocalizedException;
use Magento\User\Model\ResourceModel\User\CollectionFactory;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**  * @var \Magento\User\Model\ResourceModel\User\Collection $_userCollectionFactory */
    protected $_userCollectionFactory;
    /**  * @var \Magento\Authorization\Model\ResourceModel\Role\Collection $_roleCollectionFactory */
    protected $_roleCollectionFactory;

    /**
     * @param CollectionFactory $_userCollectionFactory
     * @param \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $_roleCollectionFactory
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        CollectionFactory                                                 $_userCollectionFactory,
        \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $_roleCollectionFactory,
        \Magento\Backend\Block\Template\Context                           $context,
        \Magento\Framework\Registry                                       $registry,
        \Magento\Framework\Data\FormFactory                               $formFactory,
        array                                                             $data = []
    )
    {
        $this->_roleCollectionFactory = $_roleCollectionFactory;
        $this->_userCollectionFactory = $_userCollectionFactory->create();
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return Form
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->getRequest()->getParams();

        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $form->setHtmlIdPrefix('storenewtask_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Add New Task'), 'class' => 'fieldset-wide']
        );
        $fieldset->addField('id', 'hidden', ['name' => 'id']);

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'value' => "ok",
                'label' => __('Task Title'),
                'id' => 'title',
                'title' => __('title'),
                'class' => 'required-entry',
                'required' => true
            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Task Description'),
                'id' => 'description',
                'title' => __('description'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $roleCollection = $this->_roleCollectionFactory->create();
        $staffTpUsers = $roleCollection->addFieldToFilter(
            "parent_id",
            [
                "eq" => $this->getRoleId()
            ]
        )->toArray();

        $fieldset->addField(
            'user',
            'select',
            [
                'name' => 'user_id',
                'label' => __('User'),
                'title' => __('user'),
                'values' => $this->_toOptionArray($staffTpUsers),
                'class' => 'required-entry',
                'required' => true
            ]
        );

        $form->setValues($model);
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        $roleCollection = $this->_roleCollectionFactory->create();
        $staffTpRoleId = $roleCollection->addFieldToFilter(
            "role_name",
            [
                "eq" => "staff of delivery service manager"
            ]
        )->toArray();
        return $staffTpRoleId["items"][0]["role_id"];
    }

    /**
     * @param array $staff
     * @return array
     */
    public function _toOptionArray(array $staff)
    {
        $users = array();
        for ($i = 0; $i < count($staff["items"]); $i++) {
            $users[$i] =
                array(
                    'value' => $staff["items"][$i]['user_id'],
                    'label' => __($staff["items"][$i]['role_name'])
                );
        }
        return $users;
    }
}
