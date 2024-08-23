<?php

declare(strict_types=1);

namespace Commerce365\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCustomerCompanyAttributes implements DataPatchInterface
{
    public function __construct(
        private readonly EavSetupFactory $setupFactory,
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly Config $eavConfig
    ) {}

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function apply()
    {
        $this->createAttribute( 'bc_customer_no', 'BC Customer Number', 'varchar', 'text', 300, false, '', true);
        $this->createAttribute('bc_company_name', 'Company Name', 'varchar', 'text', 305);
        $this->createAttribute('bc_customer_price_group', 'Customer Price Group', 'varchar', 'text', 310);
        $this->createAttribute('bc_customer_discount_group', 'Customer Discount Group', 'varchar', 'text', 311);
        $this->createAttribute('bc_payment_terms_code', 'Payment Terms Code', 'varchar', 'text', 320);
        $this->createAttribute('bc_payment_method_code', 'Payment Method Code', 'varchar', 'text', 321);

        $this->createAttribute('bc_shipment_method_code', 'Shipment Method Code', 'varchar', 'text', 322);
        $this->createAttribute('bc_shipment_agent_code', 'Shipment Method Agent Code', 'varchar', 'text', 323);
        $this->createAttribute('bc_shipment_agent_service_code', 'Shipment Agent Service Code', 'varchar', 'text', 324);
        $this->createAttribute('bc_location_code', 'Location Code', 'varchar', 'text', 325);
        $this->createAttribute('bc_blocked_code', 'Blocked Code', 'varchar', 'text', 326);
        $this->createAttribute('bc_contact_no', 'BC Contact Number', 'varchar', 'text', 327);
        $this->createAttribute('parent_customer_id', 'Parent Customer ID for Contacts', 'varchar', 'text', 328);

        return $this;
    }

    private function createAttribute($code, $label, $type, $input, $position)
    {
        $eavSetup = $this->setupFactory->create(['setup' => $this->moduleDataSetup]);
        if ($eavSetup->getAttribute(Customer::ENTITY, $code)) {
            return;
        }

        $eavSetup->addAttribute(
            Customer::ENTITY,
            $code,
            [
                'type' => $type,
                'label' => $label,
                'input' => $input,
                'required' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'position' => $position,
                'system' => false,
                'visible' => false
            ]
        );

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, $code);
        $attribute?->setData('used_in_forms', ['adminhtml_customer'])->save();
    }
}
