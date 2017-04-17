<?php

namespace Amitshree\Marketplace\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{
    /*
     *  attribute to identify a customer is vendor or not
     */
    const IS_VENDOR = 'is_vendor';

    /**
     * attribute to identify vendor account is approved or not
     */
    const APPROVE_ACCOUNT = 'approve_account';
    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        /**
         *  create customer attribute is_vendor
         */
        $customerSetup->addAttribute(Customer::ENTITY, self::IS_VENDOR,
            [
            'type' => 'int',
            'label' => 'Is Vendor?',
            'input' => 'select',
            "source"   => "Amitshree\Marketplace\Model\Config\Source\CustomerYesNoOptions",
            'required' => false,
            'default' => 0,
            'visible' => true,
            'user_defined' => true,
            'sort_order' => 210,
            'position' => 210,
            'system' => 0,
        ]);

        $is_vendor = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::IS_VENDOR)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','checkout_register','customer_account_create','customer_account_edit','adminhtml_checkout'],
            ]);

        $is_vendor->save();

        /**
         * Create customer attribute account_approve
         */
        $customerSetup->addAttribute(Customer::ENTITY, self::APPROVE_ACCOUNT,
            [
                'type' => 'int',
                'label' => 'Approve Account',
                'input' => 'select',
                "source"   => "Amitshree\Marketplace\Model\Config\Source\CustomerYesNoOptions",
                'required' => false,
                'default' => 0,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 215,
                'position' => 215,
                'system' => 0,
            ]);
        $approve_account = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::APPROVE_ACCOUNT)
              ->addData([
                  'attribute_set_id' => $attributeSetId,
                   'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer','customer_account_create','customer_account_edit'],
              ]);
        $approve_account->save();

        $setup->endSetup();
    }
}