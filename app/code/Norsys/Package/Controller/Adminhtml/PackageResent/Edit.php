<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\PackageResent;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Norsys\Package\Model\PackageFactory;
use Norsys\Package\Model\PackageStatusFactory;
use Norsys\Package\Model\PackageTrackingFactory;

class Edit extends Action {

    /** @var bool|PageFactory */
    protected $resultPageFactory = FALSE;

    /** * @var Registry */
    protected Registry $coreRegistry;

    /** * @var PackageFactory */
    protected PackageFactory $_packageFactory;

    /** @var PackageStatusFactory */
    protected PackageStatusFactory $_packageStatusFactory;

    /** @var PackageTrackingFactory */
    protected PackageTrackingFactory $_packageTrackingFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Norsys\Package\Model\PackageFactory $packageFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory
     * @param \Norsys\Package\Model\PackageTrackingFactory $packageTrackingFactory
     */
    public function __construct(
        Action\Context         $context,
        PackageFactory         $packageFactory,
        Registry               $coreRegistry,
        PageFactory            $resultPageFactory,
        PackageStatusFactory   $packageStatusFactory,
        PackageTrackingFactory $packageTrackingFactory
    ) {
        parent::__construct($context);
        $this->_packageFactory = $packageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->_packageStatusFactory = $packageStatusFactory;
        $this->_packageTrackingFactory = $packageTrackingFactory;
    }


    /**
     * @return \Magento\Backend\Model\View\Result\Page\Interceptor|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute() {
        if ($packageId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Package\Model\PackageTracking $tracking */
            $tracking = $this->_packageTrackingFactory->create()
                ->getCollection()
                ->addFieldToFilter('package.package_id', ['eq' => $packageId])
                ->join(
                    [
                        'status' => $this->_packageStatusFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.packageStatus_id= status.packageStatus_id'
                )->join(
                    [
                        'package' => $this->_packageFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.package_id= package.package_id'
                )->setOrder('created_at', 'DESC')
                ->getFirstItem();
            $this->coreRegistry->register('selectedPackage', $tracking);
            /** @var \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()
                ->getTitle()
                ->prepend((__(' Address Information')));
            return $resultPage;
        }
        else {
            return $this->_redirect('norsys_package/package/index');
        }
    }

}
