<?php

declare(strict_types=1);

namespace Commerce365\Customer\Model\Command;

use Commerce365\CustomerPrice\Service\Cache\HighLevelCacheManager;
use Magento\Framework\App\ResourceConnection;

class UpdateCustomerUpdatedAtField
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
    ) {}

    public function execute($customerId, $updatedAt)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('customer_entity');
        $connection->update(
            $tableName,
            ['updated_at' => $updatedAt],
            ['entity_id = ?' => $customerId]
        );
    }
}
