<?php

namespace Amitshree\Marketplace\Controller\Vendor;


class Profile extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    protected $logger;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
       return $this->resultPageFactory->create();
    }
}