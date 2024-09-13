<?php

declare(strict_types=1);

namespace Commerce365\Customer\Setup\Patch\Data;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddCustomerAddressAttributes implements DataPatchInterface
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
        $this->createAttribute( 'bc_shiptoaddress_code', 'BC Ship To Address Code', 'varchar', 'text', 300);
        $this->createAttribute('bc_system_id', 'BC System Id', 'varchar', 'text', 305);

        return $this;
    }

    private function createAttribute($code, $label, $type, $input, $position)
    {
        $eavSetup = $this->setupFactory->create(['setup' => $this->moduleDataSetup]);
        if ($eavSetup->getAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, $code)) {
            return;
        }

        $eavSetup->addAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
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