<?php

declare(strict_types=1);

namespace Norsys\ProductStock\Block\Adminhtml\ProductStock\Edit;

use Magento\Search\Controller\RegistryConstants;

class GenericButton
{
    /** @var \Magento\Framework\UrlInterface $urlBuilder */
    protected $urlBuilder;

    /** @var \Magento\Framework\Registry $registry */
    protected $registry;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        $contact = $this->registry->registry('productStock');
        return $contact ? $contact->getId() : null;
    }

    /**
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }


}
