<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Tracking;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Result
 *
 * @package   Norsys\Package\Controller\Tracking
 * @category  Class
 * @author Norsys
 * @copyright 2022 Norsys
 * @link https://www.norsys.fr/
 */
class Result extends Action {

    /** @var \Magento\Framework\View\Result\PageFactory  */
    protected PageFactory $resultPageFactory;

    /** @var \Magento\Framework\Controller\Result\JsonFactory  */
    protected JsonFactory $resultJsonFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        /** @var String $code */
        $code = $this->getRequest()->getParam('code');
        /** @var  \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultJsonFactory->create();
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $result->setData(['output' =>
            $resultPage->getLayout()
                ->createBlock('Norsys\Package\Block\Tracking')
                ->setTemplate('Norsys_Package::tracking/result.phtml')
                ->setData('code', $code)
                ->toHtml()
        ]);
        return $result;
    }

}
