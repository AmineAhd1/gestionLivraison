<?php
declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\Package\Status;
use Magento\Framework\Controller\ResultFactory;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {

    /** * @var \Norsys\Package\Model\PackageStatusFactory */
    protected $package_status_factory;
    /** @var \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory  */
    protected $package_tracking_factory;
    public function __construct(
        \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory $packageTracking,
        \Norsys\Package\Model\PackageStatusFactory $package_status_factory,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        $this->package_status_factory = $package_status_factory;
        $this->package_tracking_factory = $packageTracking;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return \Norsys\Package\Block\Adminhtml\Package\Status\Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm() {
        /** @var array $model */
        $model = $this->getRequest()->getParams();
        /** @var int $packageId */
        $packageId = $this->getRequest()->getParam("id");

        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'      => 'edit_form',
                    'enctype' => 'multipart/form-data',
                    'action'  => $this->getData('action'),
                    'method'  => 'post',
                ],
            ]
        );

        $form->setHtmlIdPrefix('packagestatusedit_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Set Your New Package Status'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('id', 'hidden', ['name' => 'id']);

        echo "<p style='font-weight: 500'>Your Current Package Status Is <strong>".$this->getCurrentPackageStatus($packageId)."</strong> <br></p>";

        $fieldset->addField('packagestatus', 'select', [
            'name'     => 'packagestatus',
            'label'    => __('Package Status'),
            'title'    => __('Package Status'),
            'values'   => $this->getPackageStatus(),
            'required' => TRUE,
        ]);

        $form->setValues($model);
        $form->setUseContainer(TRUE);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @param $packageId
     *
     * @return mixed
     */
    public function getCurrentPackageStatus($packageId){
        /** @var \Norsys\Package\Model\ResourceModel\PackageTracking\Collection $packageTracking */
        $packageTracking = $this->package_tracking_factory
            ->create();
        /** @var array $collection */
        $collection      = $packageTracking->addFieldToFilter(
            "package_id",
            [
                "eq" => $packageId,
            ]
        )->setOrder("created_at", "DESC")
                                           ->getFirstItem()->toArray();
        /** @var int $packageStatusId */
        $packageStatusId = $collection["packageStatus_id"];
        /** @var \Norsys\Package\Model\PackageStatus $packageStatus */
        $packageStatus   = $this->package_status_factory->create();
        $packageStatus->load($packageStatusId);
        return $packageStatus->getTitle();
    }

    /**
     * @return array
     */
    public function getPackageStatus() {
        /** @var int $packageId */
        $packageId = $this->getRequest()->getParam("id");
        /** @var \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory */
        $packageStatusFactory = $this->package_status_factory->create()
                                                             ->getCollection()
            ->addFieldToFilter("title",['nlike'=>'%'.$this->getCurrentPackageStatus($packageId).'%'])
                                                             ->addFieldToSelect("*");
        $packageStatus        = [];
        foreach ($packageStatusFactory as $elt) {
            $packageStatus[] = [
                'value' => $elt->getData("packageStatus_id"),
                'label' => __($elt->getData("title")),
            ];
        }
        return $packageStatus;
    }

}
