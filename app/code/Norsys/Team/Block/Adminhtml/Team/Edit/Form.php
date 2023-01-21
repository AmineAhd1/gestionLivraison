<?php
declare(strict_types=1);

namespace Norsys\Team\Block\Adminhtml\Team\Edit;

use Magento\Framework\Exception\LocalizedException;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @return Form
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('selectedMember');

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

        $form->setHtmlIdPrefix('teammember_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Set Your New Team Member Data'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('team_member_id', 'hidden', ['name' => 'team_member_id']);

        $fieldset->addField(
            'firstname',
            'text',
            [
                'name' => 'firstname',
                'label' => __('first name'),
                'id' => 'firstname',
                'title' => __('firstname'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'lastname',
            'text',
            [
                'name' => 'lastname',
                'label' => __('last name'),
                'id' => 'lastname',
                'title' => __('lastname'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('email'),
                'id' => 'email',
                'title' => __('email'),
                'class' => 'required-entry validate-email',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'username',
            'text',
            [
                'name' => 'username',
                'label' => __('user name'),
                'id' => 'username',
                'title' => __('username'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'newpassword',
            'password',
            [
                'name' => 'newpassword',
                'label' => __('New Password'),
                'id' => 'newpassword',
                'title' => __('newpassword'),
                'class' => 'input-text admin__control-text validate-admin-password',
                'required' => false
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
