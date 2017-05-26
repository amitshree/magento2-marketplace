<?php

namespace Amitshree\Marketplace\Block\Vendor;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class AccountDetailsSidebar extends Template
{
    /**
     * Registration constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Retrieve block title
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTitle()
    {
        return __('Vendor Info');
    }

}