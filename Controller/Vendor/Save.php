<?php

namespace Amitshree\Marketplace\Controller\Vendor;


class Save extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    protected $logger;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
       $params = $this->getRequest()->getParams();
       var_dump($params);
    }
}