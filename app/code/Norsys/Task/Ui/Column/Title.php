<?php
declare(strict_types=1);

namespace Norsys\Task\Ui\Column;

use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Title extends Column
{
    /** * @var UrlInterface $urlBuilder */
    private $urlBuilder;

    /**
     * Order Id constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param string[] $components
     * @param string[] $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['title'])) {
                    $url = $this->urlBuilder->getUrl('task/stafftptask/details', ['id' => $item['task_id']]);
                    $link = '<a style="text-decoration:none!important;" href="' . $url . '"">' . $item['title'] . '</a>';
                    $item['title'] = $link;
                }
            }
        }
        return $dataSource;
    }
}
