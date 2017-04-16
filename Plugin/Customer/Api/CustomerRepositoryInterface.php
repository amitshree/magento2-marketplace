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
       
        //todo:: disable account if applied as a vendor

        return [$customer, $passwordHash];
    }
}