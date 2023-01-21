<?php
declare(strict_types=1);

namespace Norsys\Package\Ui\Column;

use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class PackageProgress extends Column {

    /** * @var \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory */
    protected $package_tracking_factory;

    /** * @var \Norsys\Package\Model\PackageStatusFactory */
    protected $package_status_factory;

    /**
     * @param \Norsys\Package\Model\PackageStatusFactory $package_status_factory
     * @param \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory $package_tracking_factory
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Norsys\Package\Model\PackageStatusFactory $package_status_factory,
        \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory $package_tracking_factory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->package_tracking_factory = $package_tracking_factory;
        $this->package_status_factory   = $package_status_factory;
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['package_id'])) {
                    $element            = '

                            <strong>' . $this->getPackageProgressStatus($item['package_id']) . '</strong>
                    ';
                    $item['package_status'] = $element;
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
