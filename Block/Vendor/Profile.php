<?php
namespace Amitshree\Marketplace\Block\Vendor;

use Magento\Framework\View\Element\Template\Context;


class Profile extends \Magento\Framework\View\Element\Template
{

    /**
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

    public function getAboutVendor()
    {
        //@todo:: return about vendor
        return '';
    }
}