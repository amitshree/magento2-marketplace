<?php

namespace Amitshree\Marketplace\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * InstallData constructor.
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(\Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'is_vendor',
            array(
                'type' => 'int',
                "backend"  => "",
                "label"    => "Is Vendor?",
                "input"    => "select",
                "source"   => "Amitshree\Marketplace\Model\Config\Source\IsVendorOptions",
                "visible"  => true,
                "required" => false,
                "default" => "0",
                'sort_order' => 100,
                'position' => 100,
                "frontend" => "",
                "unique"     => false,
                "note"       => ""
            ));
        $is_vendor = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, ' is_vendor');
        $used_in_forms[]="adminhtml_customer";
        $used_in_forms[]="checkout_register";
        $used_in_forms[]="customer_account_create";
        $used_in_forms[]="customer_account_edit";
        $used_in_forms[]="adminhtml_checkout";
        $is_vendor->setData("used_in_forms", $used_in_forms);
        $is_vendor->save();
        $installer->endSetup();
    }

}