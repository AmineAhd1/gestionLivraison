<?php
namespace Norsys\Package\Controller\Adminhtml\PackageStock\Form;

/**
 * Interceptor class for @see \Norsys\Package\Controller\Adminhtml\PackageStock\Form
 */
class Interceptor extends \Norsys\Package\Controller\Adminhtml\PackageStock\Form implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Norsys\Package\Helper\ConfigurablePrice $helper, \Norsys\Package\Model\PackageTrackingFactory $package_tracking, \Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Norsys\Package\Model\PackageStatusFactory $packageStatusFactory, \Norsys\Package\Model\PackageTrackingFactory $packageTrackingFactory, \Norsys\Package\Model\PackageFactory $_packageFactory, \Norsys\Package\Model\CrbtFactory $_crbtFactory, \Norsys\ProductStock\Model\ProductStockFactory $_productFactory, \Magento\Backend\Model\Auth\Session $authSession, \Norsys\Package\Model\PackageProductStockFactory $_packageProductStockFactory, \Norsys\Package\Helper\GenerateUniquePackageCode $generateCodeHelper, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date)
    {
        $this->___init();
        parent::__construct($helper, $package_tracking, $context, $resultPageFactory, $packageStatusFactory, $packageTrackingFactory, $_packageFactory, $_crbtFactory, $_productFactory, $authSession, $_packageProductStockFactory, $generateCodeHelper, $date);
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
