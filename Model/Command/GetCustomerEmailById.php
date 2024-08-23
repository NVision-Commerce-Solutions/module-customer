<?php

declare(strict_types=1);

namespace Commerce365\Customer\Model\Command;

use Magento\Framework\App\ResourceConnection;

class GetCustomerEmailById
{
    public function __construct(private readonly ResourceConnection $resourceConnection) {}

    /**
     * @param $customerId
     * @return string
     */
    public function execute($customerId): string
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('customer_entity');
        $select = $connection->select()->from($tableName, ['email'])
            ->where('entity_id = ?', $customerId);

        return $connection->fetchOne($select);
    }
}
