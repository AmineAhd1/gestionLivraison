<?php

declare(strict_types=1);

namespace Norsys\Ticket\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /** @var UrlInterface $urlBuilder */
    protected UrlInterface $urlBuilder;

    /** @var Registry $registry */
    protected Registry $registry;


    /**
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }


    /**
     * @return null
     */
    public function getId()
    {
        $ticket= $this->registry->registry('ticket');
        return $ticket? $ticket->getId() : null;
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

}
