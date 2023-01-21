<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package\ReturnPackage;

use Magento\Framework\Exception\LocalizedException;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {

    /**
     * @return Form
     * @throws LocalizedException
     */
    protected function _prepareForm(): Form {
        $model = $this->_coreRegistry->registry('package_id');
        $form  = $this->_formFactory->create(
            [
                'data' => [
                    'id'      => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action'  => $this->getUrl('norsys_package/Package/savereturn'),
                    'method'  => 'post',
                ],
            ]
        );
        $form->setHtmlIdPrefix('return_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Return Informations'), 'class' => 'fieldset-wide']
        );
        $fieldset->addField(
            'package_id',
            'hidden',
            [
                'name' => 'package_id',
            ]
        );
        $fieldset->addField(
            'title',
            'text',
            [
                'name'     => 'title',
                'label'    => __('Title'),
                'id'       => 'title',
                'title'    => __('title'),
                'class'    => 'required-entry',
                'required' => TRUE,
            ]
        );
        $fieldset->addField(
            'description',
            'textarea',
            [
                'name'     => 'description',
                'label'    => __('Description'),
                'id'       => 'description',
                'title'    => __('description'),
                'class'    => 'required-entry',
                'rows'     => '4',
                'required' => TRUE,
            ]
        );
        $selectType  = $fieldset->addField(
            'type',
            'text',
            [
                'name'        => 'type',
                'label'       => __('Type'),
                'title'       => __('Return Package'),
                'class'       => 'required-entry',
                'style'       => "width: 200px;",
                'placeholder' => 'Return Package',
            ]
        );
        $selectField = $fieldset->addField(
            'emergency',
            'text',
            [
                'name'        => 'emergency',
                'label'       => __('Emergency'),
                'title'       => __('Emergency'),
                'class'       => 'required-entry',
                'style'       => "width: 200px;",
                'placeholder' => 'High',
            ]
        );
        $selectField->setAfterElementHtml("
                        <script>
                        var selectOptionEmergency = document.getElementById('return_emergency');
                        selectOptionEmergency.disabled = true;
                        </script>
        ");
        $selectType->setAfterElementHtml("
                        <script>
                        var selectOptionType = document.getElementById('return_type');
                        selectOptionType.disabled = true;
                        </script>
        ");
        $fieldset = $form->addFieldset(
            'second_fieldset',
            [
                'legend' => __('Add return attachment'),
                'class'  => 'fieldset-wide',
            ]
        );

        $fileField = $fieldset->addField(
            'file',
            'file',
            [
                'name'  => 'file',
                'label' => __('Attachment'),
                'id'    => 'file',
                'title' => __('file'),
            ]
        );

        $fileField->setAfterElementHtml("
            <label
            for='file'
            generated='true'
            class='mage-error'
            id='alertMessage'
            style='display: none; color: #555555; font-size: 1.4rem;'
            >
                File size is greater than 2MB
            </label>
        ");

        $form->setValues(['package_id' => $model]);
        $form->setUseContainer(TRUE);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
