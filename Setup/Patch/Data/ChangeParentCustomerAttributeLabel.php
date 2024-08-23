<?php

declare(strict_types=1);

namespace Commerce365\Customer\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ChangeParentCustomerAttributeLabel implements DataPatchInterface
{
    public function __construct(private readonly ModuleDataSetupInterface $moduleDataSetup) {}

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
        $this->moduleDataSetup->getConnection()->update(
            $this->moduleDataSetup->getTable('eav_attribute'),
            ['frontend_label' => 'Parent Customer'],
            ['attribute_code = ?' => 'parent_customer_id']
        );

        return $this;
    }
}
