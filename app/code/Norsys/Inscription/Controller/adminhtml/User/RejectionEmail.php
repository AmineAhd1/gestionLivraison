<?php

declare(strict_types=1);

namespace Norsys\Inscription\Controller\adminhtml\User;

use Magento\Backend\App\Action;
use Magento\Store\Model\ScopeInterface;

class RejectionEmail extends Action {

    /** @var string */
    const EMAIL_TEMPLATE = 'admin/emails/new_user_reject_template';

    /** @var string */
    const EMAIL_SENDER = 'admin/emails/sender';

    /** @var \Magento\Framework\Mail\Template\TransportBuilder $_transportBuilder */
    protected $_transportBuilder;

    /** @var \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation */
    protected $inlineTranslation;

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig */
    protected $scopeConfig;

    /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
    protected $storeManager;

    /** @var \Magento\User\Model\UserFactory $_userFactory */
    protected $_userFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\User\Model\UserFactory $userFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context              $context,
        \Magento\Framework\Mail\Template\TransportBuilder  $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface         $storeManager,
        \Magento\User\Model\UserFactory                    $userFactory
    ) {
        parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_userFactory = $userFactory;

    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        try {
            $this->inlineTranslation->suspend();
            /** @var string */
            $storeId = $this->storeManager->getStore()->getId();
            /** @var string */
            $userId = $this->getRequest()->getParam('user_id');
            /** @var  \Magento\User\Model\User */
            $model = $this->_userFactory->create();
            $model->load($userId);
            /** @var string */
            $firstname = $model->getFirstName();
            /** @var string */
            $lastname = $model->getLastName();
            /** @var  string */
            $email = $model->getEmail();

            $this->inlineTranslation->suspend();
            /** @var string */
            $sender = $this->scopeConfig->getValue(self::EMAIL_SENDER,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
            /** @var string */
            $template = $this->scopeConfig->getValue(self::EMAIL_TEMPLATE,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($template)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                        'store' => $this->storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars([
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'email' => $email,
                ])
                ->setFrom($sender)
                ->addTo($email)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage('Email has been sent');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $this->inlineTranslation->resume();
        return $this->_redirect('adminhtml/*/edit',['user_id'=>$userId]);
    }

}
