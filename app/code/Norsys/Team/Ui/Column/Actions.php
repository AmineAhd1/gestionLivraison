<?php
declare(strict_types=1);

namespace Norsys\Team\Ui\Column;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Norsys\Team\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /** Url path */
    const URL_PATH_EDIT = 'team/team/edit';
    const URL_PATH_DELETE = 'team/team/delete';
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
                if (isset($item['team_member_id'])) {
                    $item[$name][0] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['id' => $item['team_member_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name][1] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['team_member_id']]),
                        'label' => __('Delete')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
