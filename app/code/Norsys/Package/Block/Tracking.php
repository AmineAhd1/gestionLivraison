<?php

declare(strict_types=1);

namespace Norsys\Package\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Norsys\Package\Model\ResourceModel\PackageTracking\Collection;
use Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory;


/**
 * Class Tracking
 *
 * @package   Norsys\Package\Block
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Tracking extends Template {

    /** @var CollectionFactory */
    protected $_packageTrackingCollectionFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Norsys\Package\Model\ResourceModel\PackageTracking\CollectionFactory $collectionFactory
     */
    public function __construct(
        Template\Context  $context,
        CollectionFactory $collectionFactory

    ) {
        $this->_packageTrackingCollectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl(): string {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * @return \Norsys\Package\Model\ResourceModel\PackageTracking\Collection|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTrackingStatus(): ?Collection {
        if ($packageCode = $this->getCode()) {
            /** @var \Norsys\Package\Model\ResourceModel\PackageTracking\Collection $trackingStatus */
            $trackingStatus = $this->_packageTrackingCollectionFactory->create()
                ->getTrackingStatus($packageCode);
            if ($trackingStatus !== NULL) {
                return $trackingStatus;
            }
        }
        return NULL;
    }

}
