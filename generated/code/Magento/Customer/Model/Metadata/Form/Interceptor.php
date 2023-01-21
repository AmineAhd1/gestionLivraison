<?php
namespace Magento\Customer\Model\Metadata\Form;

/**
 * Interceptor class for @see \Magento\Customer\Model\Metadata\Form
 */
class Interceptor extends \Magento\Customer\Model\Metadata\Form implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Api\CustomerMetadataInterface $customerMetadataService, \Magento\Customer\Api\AddressMetadataInterface $addressMetadataService, \Magento\Customer\Model\Metadata\ElementFactory $elementFactory, \Magento\Framework\App\RequestInterface $httpRequest, \Magento\Framework\Module\Dir\Reader $modulesReader, \Magento\Framework\Validator\ConfigFactory $validatorConfigFactory, $entityType, $formCode, array $attributeValues = [], $ignoreInvisible = true, $filterAttributes = [], $isAjax = false)
    {
        $this->___init();
        parent::__construct($customerMetadataService, $addressMetadataService, $elementFactory, $httpRequest, $modulesReader, $validatorConfigFactory, $entityType, $formCode, $attributeValues, $ignoreInvisible, $filterAttributes, $isAjax);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAttributes');
        if (!$pluginInfo) {
            return parent::getAttributes();
        } else {
            return $this->___callPlugins('getAttributes', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($attributeCode)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAttribute');
        if (!$pluginInfo) {
            return parent::getAttribute($attributeCode);
        } else {
            return $this->___callPlugins('getAttribute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUserAttributes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUserAttributes');
        if (!$pluginInfo) {
            return parent::getUserAttributes();
        } else {
            return $this->___callPlugins('getUserAttributes', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSystemAttributes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSystemAttributes');
        if (!$pluginInfo) {
            return parent::getSystemAttributes();
        } else {
            return $this->___callPlugins('getSystemAttributes', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedAttributes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedAttributes');
        if (!$pluginInfo) {
            return parent::getAllowedAttributes();
        } else {
            return $this->___callPlugins('getAllowedAttributes', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function extractData(\Magento\Framework\App\RequestInterface $request, $scope = null, $scopeOnly = true)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'extractData');
        if (!$pluginInfo) {
            return parent::extractData($request, $scope, $scopeOnly);
        } else {
            return $this->___callPlugins('extractData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function compactData(array $data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'compactData');
        if (!$pluginInfo) {
            return parent::compactData($data);
        } else {
            return $this->___callPlugins('compactData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function restoreData(array $data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'restoreData');
        if (!$pluginInfo) {
            return parent::restoreData($data);
        } else {
            return $this->___callPlugins('restoreData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepareRequest(array $data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prepareRequest');
        if (!$pluginInfo) {
            return parent::prepareRequest($data);
        } else {
            return $this->___callPlugins('prepareRequest', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateData(array $data)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateData');
        if (!$pluginInfo) {
            return parent::validateData($data);
        } else {
            return $this->___callPlugins('validateData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function outputData($format = 'text')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'outputData');
        if (!$pluginInfo) {
            return parent::outputData($format);
        } else {
            return $this->___callPlugins('outputData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setInvisibleIgnored($ignoreInvisible)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setInvisibleIgnored');
        if (!$pluginInfo) {
            return parent::setInvisibleIgnored($ignoreInvisible);
        } else {
            return $this->___callPlugins('setInvisibleIgnored', func_get_args(), $pluginInfo);
        }
    }
}
