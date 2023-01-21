<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\PackageStock\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\PageRepositoryInterface;

class Generic {

    /** @var \Magento\Backend\Block\Widget\Context */
    protected Context $context;

    /** @var \Magento\Cms\Api\PageRepositoryInterface */
    protected PageRepositoryInterface $pageRepository;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepository
     */
    public function __construct(
        Context                 $context,
        PageRepositoryInterface $pageRepository
    ) {
        $this->context = $context;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

}

