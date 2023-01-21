<?php
declare(strict_types=1);

namespace Norsys\Package\Ui\Column;

use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class PackageType extends Column {

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['typePackage'])) {
                    if ($item['typePackage'] === "Simple") {
                        $element = '
                        <span class="grid-severity-notice">
                            <span>' . $item['typePackage'] . '</span>
                        </span>
                    ';
                    }
                    else {
                        $element             = '
                        <span class="grid-severity-minor">
                            <span>'. $item['typePackage'] .'</span>
                        </span>
                    ';
                    }
                    $item['typePackage'] = $element;
                }
            }
        }
        return $dataSource;
    }

}
