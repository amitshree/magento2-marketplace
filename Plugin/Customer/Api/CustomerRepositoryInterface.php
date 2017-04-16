<?php

namespace Amitshree\Marketplace\Plugin\Customer\Api;


class CustomerRepositoryInterface
{
    /**
     * Check if customer applied to become a seller
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param null $passwordHash
     * @return array
     */
    public function beforeSave(\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
                               \Magento\Customer\Api\Data\CustomerInterface $customer,
                               $passwordHash = null)
    {
       
       /* $isVendor = $customerRepository->getById($customer->getId())->getCustomAttribute('is_vendor')->getValue();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('is vendor'. $isVendor);
*/
        return [$customer, $passwordHash];
    }
}