<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\PackageResent\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Exception\LocalizedException;


class Form extends Generic {

    /**
     * @return Form
     * @throws LocalizedException
     */
    protected function _prepareForm(): Form {
        /** @var \Norsys\Package\Model\PackageTracking $model */
        $model = $this->_coreRegistry->registry('selectedPackage');
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

        /** @var \Magento\Framework\Data\Form\Element\Fieldset $fieldset */
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Enter the new address information'),
                'class' => 'fieldset-wide',
            ]
        );
        $fieldset->addField('package_id', 'hidden', ['name' => 'package_id']);
        $fieldset->addField('title', 'hidden', ['name' => 'title']);
        $fieldset->addField('packageTracking_id', 'hidden', ['name' => 'packageTracking_id']);
        $cities = [['value' => '-- Choose City --', 'label' => '--Choose City--'],
            ['value' => 'Casablanca', 'label' => 'Casablanca'],
            ['value' => 'El Kelaa des Srarhna', 'label' => 'El Kelaa des Srarhna'],
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
            ['value' => 'Arfoud', 'label' => 'Arfoud']];
        $fieldset->addField(
            'city',
            'select',
            [
                'name' => 'city',
                'label' => __('City'),
                'title' => __('city'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $cities
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
                'class' => 'validate-number',
                'required' => true,
                'maxlength'=>'5',
                'onchange' => 'checkLength()',
            ]
        );
        $zipCode->setAfterElementHtml("
            <label  for='file'
            generated='true'
            class='mage-error'
            id='alertMessage'
            style='display: none; color: #555555; font-size: 1.4rem;'>
             length must be exactly 5 characters
             </label>
               <script>
                        fieldZip = document.getElementById('zipCode');
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
        $form->setValues($model->getData());
        $form->setUseContainer(TRUE);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
