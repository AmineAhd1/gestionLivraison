<?php

namespace Norsys\Inscription\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Model\AbstractModel;

class Inscription extends \Magento\Framework\View\Element\Template
{
    /**
     * @param Template\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        return parent::__construct($context);

    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('inscription/account/submit');
    }
}
