<?php
namespace Norsys\Package\Controller\Adminhtml\Package\SaveReturn;

/**
 * Interceptor class for @see \Norsys\Package\Controller\Adminhtml\Package\SaveReturn
 */
class Interceptor extends \Norsys\Package\Controller\Adminhtml\Package\SaveReturn implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, \Norsys\Ticket\Model\TicketFactory $ticketFactory, \Norsys\Ticket\Model\TicketAttachmentFactory $ticketAttachmentFactory, \Magento\Framework\Filesystem $filesystem, \Norsys\Package\Model\PackageFactory $_packageFactory, \Magento\Backend\Model\Auth\Session $authSession, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Image\AdapterFactory $adapterFactory, \Norsys\Package\Model\PackageStatusFactory $_packageStatusFactory, \Norsys\Package\Model\PackageTrackingFactory $_packageTrackingFactory, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date)
    {
        $this->___init();
        parent::__construct($context, $pageFactory, $ticketFactory, $ticketAttachmentFactory, $filesystem, $_packageFactory, $authSession, $fileUploaderFactory, $coreRegistry, $adapterFactory, $_packageStatusFactory, $_packageTrackingFactory, $date);
    }

    /**
     * {@inheritdoc}
     */
    public function execute() : \Magento\Framework\App\ResponseInterface
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
