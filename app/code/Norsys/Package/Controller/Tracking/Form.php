<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Tracking;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Form
 *
 * @package   Norsys\Package\Controller\Tracking
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Form extends \Magento\Framework\App\Action\Action {

    /** @var PageFactory */
    protected PageFactory $_pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute() {
        return $this->_pageFactory->create();
    }

}
