<?php

declare(strict_types=1);

namespace Norsys\Inscription\Controller\adminhtml\User;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class InactiveUser extends Action {

    /** @var bool|PageFactory */
    protected $resultPageFactory = FALSE;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResultInterface|Page
     */
    public function execute() {
        return $this->resultPageFactory->create();
    }

}
