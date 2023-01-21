<?php

declare(strict_types=1);

namespace Norsys\Package\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PackageAction extends Column {

    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['view'] = [
                    'href' => $this->urlBuilder->getUrl('norsys_package/package/detail', [
                        'id' => $item['package_id'],
                        'status' => $item['title'],
                    ]),
                    'label' =>__('View')
                ];
                if ($item['title'] !== 'Returned' and $item['title'] == 'Delivered') {
                    $item[$this->getData('name')]['ticket'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'norsys_package/Package/returnPackage',
                            ['package_id' => $item['package_id']]),
                        'label' => __('Ticket'),
                    ];
                }

            }
        }
        return $dataSource;
    }

}
