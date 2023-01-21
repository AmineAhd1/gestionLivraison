<?php
declare(strict_types=1);

namespace Norsys\Team\Ui\Column;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Norsys\Team\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class Teamsactions extends Column {

    /** @var string */
    const URL_PATH_VIEW = 'team/team/viewdetailsteams';

    /** @var UrlBuilder */
    protected UrlBuilder $actionUrlBuilder;

    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Norsys\Team\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder $actionUrlBuilder
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder         $actionUrlBuilder,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                /** @var string $name */
                $name = $this->getData('name');
                if (isset($item['team_id'])) {
                    $item[$name][0] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_VIEW, ['id' => $item['team_id']]),
                        'label' => __('View'),
                    ];
                }
            }
        }
        return $dataSource;
    }

}
