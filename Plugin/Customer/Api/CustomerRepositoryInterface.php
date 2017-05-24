<?php

namespace Amitshree\Marketplace\Plugin\Customer\Api;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Api\Data\CustomerInterface;


class CustomerRepositoryInterface
{
    /**
     * Check if customer applied to become a seller
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     * @param null $passwordHash
     * @return array
     */
    /*public function afterSave(CustomerRepository $subject, CustomerInterface $customer)
    {
       
        $isVendor = $subject->getById($customer->getId())->getCustomAttribute('is_vendor')->getValue();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('is vendorrr'. $isVendor);

        return $customer;
    }*/
}