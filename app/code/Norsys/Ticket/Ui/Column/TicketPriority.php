<?php

namespace Norsys\Ticket\Ui\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TicketPriority extends Column {

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        array              $components = [],
        array              $data = []
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
                if (isset($item['priority'])) {
                    if ($item['priority'] === "High") {
                        $element = '
                        <span class="grid-severity-critical">
                            <span>' . $item['priority'] . '</span>
                        </span>
                    ';
                    }elseif ($item['priority'] === "Average"){
                        $element = '
                        <span class="grid-severity-notice">
                            <span>' . $item['priority'] . '</span>
                        </span>
                    ';
                    }
                    else {
                        $element = '
                        <span class="grid-severity-minor">
                            <span>' . $item['priority'] . '</span>
                        </span>
                    ';
                    }
                    $item['priority'] = $element;
                }
            }
        }
        return $dataSource;
    }

}
