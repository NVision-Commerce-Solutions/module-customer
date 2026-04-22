<?php

declare(strict_types=1);

namespace Commerce365\Customer\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class DisableHyvaCheckoutBcAttributes implements DataPatchInterface
{
    private const BC_ATTRIBUTE_CODES = [
        'bc_system_id',
        'bc_shiptoaddress_code',
        'bc_customer_no',
        'bc_company_name',
        'bc_customer_price_group',
        'bc_customer_discount_group',
        'bc_payment_terms_code',
        'bc_payment_method_code',
        'bc_shipment_method_code',
        'bc_shipment_agent_code',
        'bc_shipment_agent_service_code',
        'bc_location_code',
        'bc_blocked_code',
        'bc_contact_no',
        'parent_customer_id',
        'bc_customer_currency',
    ];

    private const CONFIG_PATHS = [
        'hyva_themes_checkout/component/shipping_address/eav_attribute_form_fields',
        'hyva_themes_checkout/component/billing_address/eav_attribute_form_fields',
    ];

    public function __construct(
        private readonly ResourceConnection $resourceConnection
    ) {}

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [
            AddCustomerAddressAttributes::class,
            AddCustomerCompanyAttributes::class,
        ];
    }

    public function apply(): self
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('core_config_data');

        foreach (self::CONFIG_PATHS as $configPath) {
            $rows = $connection->fetchAll(
                $connection->select()->from($table)->where('path = ?', $configPath)
            );

            foreach ($rows as $row) {
                $mapping = json_decode($row['value'], true);
                if (!is_array($mapping)) {
                    continue;
                }

                $updated = false;
                foreach ($mapping as &$field) {
                    if (isset($field['attribute_code']) && in_array($field['attribute_code'], self::BC_ATTRIBUTE_CODES, true)) {
                        if (($field['enabled'] ?? '1') !== '0') {
                            $field['enabled'] = '0';
                            $updated = true;
                        }
                    }
                }
                unset($field);

                if ($updated) {
                    $connection->update(
                        $table,
                        ['value' => json_encode($mapping)],
                        ['config_id = ?' => $row['config_id']]
                    );
                }
            }
        }

        return $this;
    }
}
