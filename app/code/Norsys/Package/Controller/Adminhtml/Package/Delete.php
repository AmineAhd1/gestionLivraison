<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Package;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Norsys\Package\Model\PackageFactory;

/**
 * class Delete
 *
 * @package  Norsys\Package\Controller\Adminhtml\Package
 * @category  class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Delete extends Action
{

    /** @var PackageFactory */
    protected PackageFactory $_packageFactory;

   /**
     * @param \Norsys\Package\Model\PackageFactory $packageFactory
     * @param Context $context
     */
    public function __construct(
        PackageFactory $packageFactory,
        Context $context
    )
    {
        $this->_packageFactory = $packageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        if ($packageId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Package\Model\Package $package */
            $package = $this->_packageFactory->create()->load($packageId);
            if ($parentPackageId = $package->getParentId()) {
                /** @var \Norsys\Package\Model\Package $packageParent */
                $packageParent = $this->_packageFactory->create()
                    ->load($parentPackageId);
                    $packageParent->setIsDeleted(TRUE);
                    $packageParent->save();
            }
            $package->setIsDeleted(TRUE);
            try {
                $package->save();
                $this->messageManager->addSuccess(__('The package has been deleted !'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Error while trying to delete package '));
            }
        }
        
        return $this->_redirect('norsys_package/package/index');
    }

}