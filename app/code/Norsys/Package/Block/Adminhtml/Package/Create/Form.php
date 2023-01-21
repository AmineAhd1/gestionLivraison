<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package\Create;

use Magento\Framework\Exception\LocalizedException;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {

    /**
     * @return Form
     * @throws LocalizedException
     */
    protected function _prepareForm(): Form {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                ],
            ]
        );
        $form->setHtmlIdPrefix('package_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Package Informations'), 'class' => 'fieldset-wide']
        );
        $fieldset->addField(
            'receiverFullName',
            'text',
            [
                'name' => 'receiverFullName',
                'label' => __('Receiver FullName'),
                'id' => 'receiverFullName',
                'title' => __('Receiver FullName'),
                'class' => 'required-entry',
                'required' => TRUE,
            ]
        );
        $phoneNumber =$fieldset->addField(
            'phoneNumber',
            'text',
            [
                'name' => 'phoneNumber',
                'label' => __('Phone Number'),
                'id' => 'phoneNumber',
                'title' => __('Phone Number'),
                'class' => 'validate-number',
                'maxlength'=>'10',
                'onchange' => 'checkLengthPhone()',
                'required' => TRUE,
            ]
        );
        $cities = [
            ['value' => '-- Choose City --', 'label' => '--Choose City--'],
            ['value' => 'Casablanca', 'label' => 'Casablanca'],
            [
                'value' => 'El Kelaa des Srarhna',
                'label' => 'El Kelaa des Srarhna',
            ],
            ['value' => 'Fès', 'label' => 'Fès'],
            ['value' => 'Tanger', 'label' => 'Tanger'],
            ['value' => 'Marrakech', 'label' => 'Marrakech'],
            ['value' => 'Sale', 'label' => 'Sale'],
            ['value' => 'Rabat', 'label' => 'Rabat'],
            ['value' => 'Ouarzazate', 'label' => 'Ouarzazate'],
            ['value' => 'Meknès', 'label' => 'Meknès'],
            ['value' => 'Kenitra', 'label' => 'Kenitra'],
            ['value' => 'Agadir', 'label' => 'Agadir'],
            ['value' => 'Oujda', 'label' => 'Oujda'],
            ['value' => 'Tétouan', 'label' => 'Tétouan'],
            ['value' => 'Temara', 'label' => 'Temara'],
            ['value' => 'Safi', 'label' => 'Safi'],
            ['value' => 'Laâyoune', 'label' => 'Laâyoune'],
            ['value' => 'Mohammedia', 'label' => 'Mohammedia'],
            ['value' => 'Kouribga', 'label' => 'Kouribga'],
            ['value' => 'Béni Mellal', 'label' => 'Béni Mellal'],
            ['value' => 'El Jadida', 'label' => 'El Jadida'],
            ['value' => 'Ait Melloul', 'label' => 'Ait Melloul'],
            ['value' => 'Nador', 'label' => 'Nador'],
            ['value' => 'Taza', 'label' => 'Taza'],
            ['value' => 'Settat', 'label' => 'Settat'],
            ['value' => 'Barrechid', 'label' => 'Barrechid'],
            ['value' => 'Al Khmissat', 'label' => ' Al Khmissat'],
            ['value' => 'Inezgane', 'label' => 'Inezgane'],
            ['value' => 'Ksar El Kebir', 'label' => 'Ksar El Kebir'],
            ['value' => 'Guelmim', 'label' => 'Guelmim'],
            ['value' => 'Khénifra', 'label' => 'Khénifra'],
            ['value' => 'Berkane', 'label' => 'Berkane'],
            ['value' => 'Bouskoura', 'label' => 'Bouskoura'],
            ['value' => 'Al Fqih Ben Çalah', 'label' => 'Al Fqih Ben Çalah'],
            ['value' => 'Oued Zem', 'label' => 'Oued Zem'],
            ['value' => 'Sidi Slimane', 'label' => 'Sidi Slimane'],
            ['value' => 'Errachidia', 'label' => 'Errachidia'],
            ['value' => 'Guercif', 'label' => 'Guercif'],
            ['value' => 'Tiflet', 'label' => 'Tiflet'],
            ['value' => 'Sefrou', 'label' => 'Sefrou'],
            ['value' => 'Essaouira', 'label' => 'Essaouira'],
            ['value' => 'Fnidq', 'label' => 'Fnidq'],
            ['value' => 'Ben Guerir', 'label' => 'Ben Guerir'],
            ['value' => 'Ad Dakhla', 'label' => 'Ad Dakhla'],
            ['value' => 'Tiznit', 'label' => 'Tiznit'],
            ['value' => 'Tan-Tan', 'label' => 'Tan-Tan'],
            ['value' => 'Martil', 'label' => 'Martil'],
            ['value' => 'Skhirate', 'label' => 'Skhirate'],
            ['value' => 'Ouezzane', 'label' => 'Ouezzane'],
            ['value' => 'Benslimane', 'label' => 'Benslimane'],
            ['value' => 'Midalt', 'label' => 'Midalt'],
            ['value' => 'Azrou', 'label' => 'Azrou'],
            ['value' => 'Semara', 'label' => 'Semara'],
            ['value' => 'Mrirt', 'label' => 'Mrirt'],
            ['value' => 'Jerada', 'label' => 'Jerada'],
            ['value' => 'Tineghir', 'label' => 'Tineghir'],
            ['value' => 'Chefchaouene', 'label' => 'Chefchaouene'],
            ['value' => 'Azemmour', 'label' => 'Azemmour'],
            ['value' => 'Zagora', 'label' => 'Zagora'],
            ['value' => 'Aziylal', 'label' => 'Aziylal'],
            ['value' => 'Taounate', 'label' => 'Taounate'],
            ['value' => 'Bouznika', 'label' => 'Bouznika'],
            ['value' => 'Mediouna', 'label' => 'Mediouna'],
            ['value' => 'Asilah', 'label' => 'Asilah'],
            ['value' => 'Taza', 'label' => 'Taza'],
            ['value' => 'Al Hoceïma', 'label' => 'Al Hoceïma'],
            ['value' => 'Moulay Bousselham', 'label' => 'Moulay Bousselham'],
            ['value' => 'Qasbat Tadla', 'label' => 'Qasbat Tadla'],
            ['value' => 'Arfoud', 'label' => 'Arfoud'],
        ];
        $fieldset->addField(
            'city',
            'select',
            [
                'name' => 'city',
                'label' => __('City'),
                'title' => __('city'),
                'class' => 'required-entry',
                'required' => TRUE,
                'values' => $cities,
            ]
        );
        $fieldset->addField(
            'street',
            'text',
            [
                'name' => 'street',
                'label' => __('Street'),
                'id' => 'street',
                'title' => __('street'),
                'class' => 'required-entry',
                'required' => TRUE,
            ]
        );
        $zipCode=$fieldset->addField(
            'zipCode',
            'text',
            [
                'name' => 'zipCode',
                'label' => __('Zip Code'),
                'id' => 'zipCode',
                'title' => __('Zip Code'),
                'required' => TRUE,
                'maxlength'=>'5',
                'onchange' => 'checkLength()',
            ]
        );
        $phoneNumber->setAfterElementHtml("
            <label  for='file'
            generated='true'
            class='mage-error'
            id='alertMessages'
            style='display: none; color: #555555; font-size: 1.4rem;'>
             length must be exactly 10 numbers
             </label>
               <script>
                        fieldPhone = document.getElementById('package_phoneNumber');
                        function checkLengthPhone() {
                        if (fieldPhone.value.length < 10) {
                          document.getElementById('alertMessages').style.display='block';
                          document.getElementById('save').setAttribute('disabled', true);
                          }else{
                            document.getElementById('alertMessages').style.display='none';
                            document.getElementById('save').removeAttribute('disabled');
                          }
}
                </script>
        ");
        $zipCode->setAfterElementHtml("
            <label  for='file'
            generated='true'
            class='mage-error'
            id='alertMessage'
            style='display: none; color: #555555; font-size: 1.4rem;'>
             length must be exactly 5 numbers
             </label>
               <script>
                        fieldZip = document.getElementById('package_zipCode');
                        function checkLength() {
                        if (fieldZip.value.length < 5) {
                          document.getElementById('alertMessage').style.display='block';
                          document.getElementById('save').setAttribute('disabled', true);
                          }else{
                            document.getElementById('alertMessage').style.display='none';
                            document.getElementById('save').removeAttribute('disabled');
                          }
}
                </script>
        ");
        $fieldset->addField(
            'weight',
            'text',
            [
                'name' => 'weight',
                'label' => __('Weight(Kg)'),
                'id' => 'weight',
                'title' => __('weight'),
                'class' => 'validate-number',
                'required' => TRUE,
            ]
        );
        $fieldset = $form->addFieldset(
            'second_fieldset',
            ['legend' => __('CRBT Informations'), 'class' => 'fieldset-wide']
        );
        $yesno = [
            ['value' => 'Payed', 'label' => 'Payed'],
            [
                'value' => 'Not Payed',
                'label' => 'Not Payed',
                'selected' => TRUE,
            ],
        ];
        $selectField = $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'title' => __('status'),
                'class' => 'required-entry',
                'required' => TRUE,
                'onchange' => 'showHideField()',
                'values' => $yesno,
            ]
        );
        $selectField->setAfterElementHtml("

                        <script>
                        var selectOption = document.getElementById('package_status');
                        selectOption.options[1].selected=true;
                        function showHideField() {
                            var elements;
                            elements = document.getElementById('package_priceCrbt');
                            var parent = document.querySelector('.field-priceCrbt');

                            if (elements.style.visibility === 'hidden') {
                                parent.querySelector('label :nth-child(1)').style.visibility='visible';
                                 elements.style.visibility = 'visible';
                                 elements.setAttribute('required',true);
                              } else {
                                parent.querySelector('label :nth-child(1)').style.visibility='hidden';
                                elements.style.visibility = 'hidden';
                                elements.removeAttribute('required',false);
                              }
                        }
                        </script>
        ");
        $fieldset->addField(
            'priceCrbt',
            'text',
            [
                'name' => 'priceCrbt',
                'label' => __('Price'),
                'id' => 'priceCrbt',
                'title' => __('price'),
                'class' => 'validate-number',
            ]
        );
        $form->setValues(NULL);
        $form->setUseContainer(TRUE);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
