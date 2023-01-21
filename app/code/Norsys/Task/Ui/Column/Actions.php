<?php
declare(strict_types=1);

namespace Norsys\Task\Ui\Column;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Norsys\Task\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /** Url path */
    const URL_PATH_TASK_DETAILS = 'task/task/details';
    const URL_PATH_TICKET_DETAILS = 'ticket/ticket/detail';
    /** @var UrlBuilder $actionUrlBuilder */
    protected $actionUrlBuilder;
    /** @var UrlInterface $urlBuilder */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
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
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['task_id'])) {
                    $item[$name][0] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_TASK_DETAILS, ['id' => $item['task_id']]),
                        'label' => __('Task Details')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
