<?php

namespace Amitshree\Marketplace\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Registration extends Template
{
    /**
     * Registration constructor.
     * @param Context $context
     * @param \Amitshree\Marketplace\Model\Config\Source\IsVendorOptions $isVendorOptions
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Amitshree\Marketplace\Model\Config\Source\IsVendorOptions $isVendorOptions,
        array $data
    )
    {
        $this->isVendorOptions = $isVendorOptions;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     *
     */
    public function getIsVendorHTML()
    {
        //$isVendor = $this->isVendorOptions->getOptionArray();
        //todo:: create is vendor dropdown html
    }
}