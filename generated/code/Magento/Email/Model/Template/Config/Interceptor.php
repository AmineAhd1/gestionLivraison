<?php
namespace Magento\Email\Model\Template\Config;

/**
 * Interceptor class for @see \Magento\Email\Model\Template\Config
 */
class Interceptor extends \Magento\Email\Model\Template\Config implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Email\Model\Template\Config\Data $dataStorage, \Magento\Framework\Module\Dir\Reader $moduleReader, \Magento\Framework\View\FileSystem $viewFileSystem, \Magento\Framework\View\Design\Theme\ThemePackageList $themePackages, \Magento\Framework\Filesystem\Directory\ReadFactory $readDirFactory)
    {
        $this->___init();
        parent::__construct($dataStorage, $moduleReader, $viewFileSystem, $themePackages, $readDirFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableTemplates()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAvailableTemplates');
        if (!$pluginInfo) {
            return parent::getAvailableTemplates();
        } else {
            return $this->___callPlugins('getAvailableTemplates', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getThemeTemplates($templateId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getThemeTemplates');
        if (!$pluginInfo) {
            return parent::getThemeTemplates($templateId);
        } else {
            return $this->___callPlugins('getThemeTemplates', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parseTemplateIdParts($templateId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'parseTemplateIdParts');
        if (!$pluginInfo) {
            return parent::parseTemplateIdParts($templateId);
        } else {
            return $this->___callPlugins('parseTemplateIdParts', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateLabel($templateId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplateLabel');
        if (!$pluginInfo) {
            return parent::getTemplateLabel($templateId);
        } else {
            return $this->___callPlugins('getTemplateLabel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateType($templateId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplateType');
        if (!$pluginInfo) {
            return parent::getTemplateType($templateId);
        } else {
            return $this->___callPlugins('getTemplateType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateModule($templateId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplateModule');
        if (!$pluginInfo) {
            return parent::getTemplateModule($templateId);
        } else {
            return $this->___callPlugins('getTemplateModule', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateArea($templateId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplateArea');
        if (!$pluginInfo) {
            return parent::getTemplateArea($templateId);
        } else {
            return $this->___callPlugins('getTemplateArea', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateFilename($templateId, $designParams = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplateFilename');
        if (!$pluginInfo) {
            return parent::getTemplateFilename($templateId, $designParams);
        } else {
            return $this->___callPlugins('getTemplateFilename', func_get_args(), $pluginInfo);
        }
    }
}
