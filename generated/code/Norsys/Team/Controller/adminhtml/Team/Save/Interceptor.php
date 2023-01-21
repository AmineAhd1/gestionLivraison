<?php
namespace Norsys\Team\Controller\adminhtml\Team\Save;

/**
 * Interceptor class for @see \Norsys\Team\Controller\adminhtml\Team\Save
 */
class Interceptor extends \Norsys\Team\Controller\adminhtml\Team\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Norsys\Team\Model\ResourceModel\Team\CollectionFactory $_teamcollectionFactory, \Norsys\Team\Model\ResourceModel\TeamMember\CollectionFactory $_teamMemberCollectionFactory, \Norsys\Team\Model\TeamMemberFactory $_teamMemberFactory, \Magento\Backend\Model\Auth\Session $authSession, \Magento\Backend\App\Action\Context $context, \Magento\User\Model\UserFactory $userFactory, \Magento\Authorization\Model\RoleFactory $roleFactory, \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $_roleCollectionFactory)
    {
        $this->___init();
        parent::__construct($_teamcollectionFactory, $_teamMemberCollectionFactory, $_teamMemberFactory, $authSession, $context, $userFactory, $roleFactory, $_roleCollectionFactory);
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
    public function isValid($password, $confirmPassword, $username)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isValid');
        if (!$pluginInfo) {
            return parent::isValid($password, $confirmPassword, $username);
        } else {
            return $this->___callPlugins('isValid', func_get_args(), $pluginInfo);
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
