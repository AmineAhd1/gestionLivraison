<?php
namespace Norsys\Package\Controller\Adminhtml\Invoice\Printing;

/**
 * Interceptor class for @see \Norsys\Package\Controller\Adminhtml\Invoice\Printing
 */
class Interceptor extends \Norsys\Package\Controller\Adminhtml\Invoice\Printing implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Norsys\Package\Model\CrbtFactory $crbtFactory, \Magento\User\Model\UserFactory $userFactory, \Norsys\Package\Model\PackageProductStockFactory $packageProductStockFactory, \Norsys\ProductStock\Model\ProductStockFactory $productStockFactory, \Norsys\Package\Model\PackageFactory $packageFactory)
    {
        $this->___init();
        parent::__construct($context, $fileFactory, $date, $crbtFactory, $userFactory, $packageProductStockFactory, $productStockFactory, $packageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageUser() : ?\Magento\User\Model\User
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPackageUser');
        if (!$pluginInfo) {
            return parent::getPackageUser();
        } else {
            return $this->___callPlugins('getPackageUser', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPackage() : ?\Norsys\Package\Model\Package
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPackage');
        if (!$pluginInfo) {
            return parent::getPackage();
        } else {
            return $this->___callPlugins('getPackage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCRBT() : ?\Magento\Framework\DataObject
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCRBT');
        if (!$pluginInfo) {
            return parent::getCRBT();
        } else {
            return $this->___callPlugins('getCRBT', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageProduct()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPackageProduct');
        if (!$pluginInfo) {
            return parent::getPackageProduct();
        } else {
            return $this->___callPlugins('getPackageProduct', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function _processUrlKeys()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, '_processUrlKeys');
        if (!$pluginInfo) {
            return parent::_processUrlKeys();
        } else {
            return $this->___callPlugins('_processUrlKeys', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($route = '', $params = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUrl');
        if (!$pluginInfo) {
            return parent::getUrl($route, $params);
        } else {
            return $this->___callPlugins('getUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getActionFlag()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getActionFlag');
        if (!$pluginInfo) {
            return parent::getActionFlag();
        } else {
            return $this->___callPlugins('getActionFlag', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRequest');
        if (!$pluginInfo) {
            return parent::getRequest();
        } else {
            return $this->___callPlugins('getRequest', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResponse');
        if (!$pluginInfo) {
            return parent::getResponse();
        } else {
            return $this->___callPlugins('getResponse', func_get_args(), $pluginInfo);
        }
    }
}
