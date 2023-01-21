<?php

declare(strict_types=1);

namespace Norsys\Ticket\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email extends AbstractHelper
{
    const XML_PATH_EMAIL_TEMPLATE_FIELD = 'admin/emails/ticket_validation_template';

    /** @var Context $_scopeConfig */
    protected Context $_scopeConfig;

    /** @var StoreManagerInterface $_storeManager */
    protected StoreManagerInterface $_storeManager;

    /** @var StateInterface $inlineTranslation */
    protected StateInterface $inlineTranslation;

    /** @var TransportBuilder $_transportBuilder */
    protected TransportBuilder $_transportBuilder;


    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        Context              $context,
        StoreManagerInterface         $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder  $transportBuilder
    )
    {
        $this->_scopeConfig = $context;
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
    }

    /**
     * @param $path
     * @param $storeId
     * @return mixed
     */
    protected function getConfigValue($path, $storeId)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return StoreInterface
     * @throws NoSuchEntityException
     */
    public function getStore(): StoreInterface
    {
        return $this->_storeManager->getStore();
    }

    /**
     * @param $xmlPath
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getTemplateId($xmlPath)
    {
        return $this->getConfigValue($xmlPath, $this->getStore()->getStoreId());
    }

    /**
     * @param $templateId
     * @param $emailTemplateVariables
     * @param $senderInfo
     * @param $receiverInfo
     * @return TransportBuilder
     * @throws NoSuchEntityException
     */
    public function generateTemplate($templateId, $emailTemplateVariables, $senderInfo, $receiverInfo): TransportBuilder
    {
        return $this->_transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions(
                [
                    'area' => Area::AREA_ADMINHTML,
                    'store' => $this->getStore()->getId(),
                ]
            )
            ->setTemplateVars($emailTemplateVariables)
            ->setFrom($senderInfo)
            ->addTo($receiverInfo['email'], $receiverInfo['name']);
    }

    /**
     * @param $emailTemplateVariables
     * @param $senderInfo
     * @param $receiverInfo
     * @return void
     * @throws LocalizedException
     * @throws MailException
     * @throws NoSuchEntityException
     */
    public function sendTicketValidationEmail($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        /** @var string $templateId */
        $templateId= $this->getTemplateId(self::XML_PATH_EMAIL_TEMPLATE_FIELD);
        $this->inlineTranslation->suspend();
        $this->generateTemplate($templateId,$emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

}
