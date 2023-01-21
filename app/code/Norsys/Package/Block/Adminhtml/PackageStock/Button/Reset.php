<?php

declare(strict_types=1);

namespace Norsys\Package\Block\Adminhtml\PackageStock\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Reset implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData(): array {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}
