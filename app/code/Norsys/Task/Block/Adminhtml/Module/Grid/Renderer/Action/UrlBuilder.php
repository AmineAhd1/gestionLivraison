<?php
declare(strict_types=1);
namespace Norsys\Task\Block\Adminhtml\Module\Grid\Renderer\Action;

class UrlBuilder
{
    /**  * @var \Magento\Framework\UrlInterface $frontendUrlBuilder */
    protected $frontendUrlBuilder;

    /**
     * @param \Magento\Framework\UrlInterface $frontendUrlBuilder
     */
    public function __construct(\Magento\Framework\UrlInterface $frontendUrlBuilder)
    {
        $this->frontendUrlBuilder = $frontendUrlBuilder;
    }

    /**
     * Get action url
     *
     * @param string $routePath
     * @param string $scope
     * @param string $store
     * @return string
     */
    public function getUrl($routePath, $scope, $store)
    {
        $this->frontendUrlBuilder->setScope($scope);
        return $this->frontendUrlBuilder->getUrl(
            $routePath,
            ['_current' => false, '_query' => '___store=' . $store]
        );
    }
}
