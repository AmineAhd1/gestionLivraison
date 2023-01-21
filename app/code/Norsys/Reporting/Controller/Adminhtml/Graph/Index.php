<?php

declare(strict_types=1);

namespace Norsys\Reporting\Controller\Adminhtml\Graph;

/**
 * Class Index
 *
 * @package   Norsys\Reporting\Controller\Adminhtml\Graph
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Index extends \Magento\Backend\App\Action {

    /** @var bool|\Magento\Framework\View\Result\PageFactory $resultPageFactory */
    protected $resultPageFactory = FALSE;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute() {
        /** @var  \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Reporting')));
        return $resultPage;
    }

}
