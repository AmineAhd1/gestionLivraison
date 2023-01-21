<?php
declare(strict_types=1);

namespace Norsys\Package\Ui\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Norsys\Task\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class Actions extends Column {

    /** Url path */
    const URL_PATH_PACKAGE_DETAILS = 'norsys_package/package/detail';

    const URL_PATH_PACKAGE_STATUS_EDIT= 'norsys_package/package/EditStatus';

    /** @var UrlBuilder $actionUrlBuilder */
    protected $actionUrlBuilder;

    /** @var UrlInterface $urlBuilder */
    protected $urlBuilder;

    /** * @var \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory */
    protected $package_tracking_factory;

    /** * @var \Norsys\Package\Model\PackageStatusFactory */
    protected $package_status_factory;

    /**
     * @param \Norsys\Package\Model\PackageStatusFactory $package_status_factory
     * @param \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory $package_tracking_factory
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Norsys\Task\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder $actionUrlBuilder
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Norsys\Package\Model\PackageStatusFactory $package_status_factory,
        \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory $package_tracking_factory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder               = $urlBuilder;
        $this->actionUrlBuilder         = $actionUrlBuilder;
        $this->package_tracking_factory = $package_tracking_factory;
        $this->package_status_factory   = $package_status_factory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['package_id'])) {
                    $item[$name][0] = [
                        'href'  => $this->urlBuilder->getUrl(self::URL_PATH_PACKAGE_DETAILS, [
                            'id'     => $item['package_id'],
                            'status' => $this->getPackageProgressStatus($item['package_id']),
                        ]),
                        'label' => __('Package Details'),
                    ];
                    $item[$name][1] = [
                        'href'  => $this->urlBuilder->getUrl(self::URL_PATH_PACKAGE_STATUS_EDIT, [
                            'id'     => $item['package_id']
                        ]),
                        'label' => __('Edit Package Status'),
                    ];
                }
            }
        }
        return $dataSource;
    }

    /**
     * @param $packageId
     *
     * @return mixed
     */
    public function getPackageProgressStatus($packageId) {
        /** @var \Norsys\Package\Model\ResourceModel\PackageTracking\Collection $packageTracking */
        $packageTracking = $this->package_tracking_factory
            ->create();
        $collection      = $packageTracking->addFieldToFilter(
            "package_id",
            [
                "eq" => $packageId,
            ]
        )->setOrder("created_at", "DESC")
                                           ->getFirstItem()->toArray();
        $packageStatusId = $collection["packageStatus_id"];
        $packageStatus   = $this->package_status_factory->create();
        $packageStatus->load($packageStatusId);
        return $packageStatus->getTitle();
    }

}
