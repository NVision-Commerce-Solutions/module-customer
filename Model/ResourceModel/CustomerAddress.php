<?php

declare(strict_types=1);

namespace Commerce365\Customer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerAddress extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('commerce365_customer_address', 'entity_id');
    }
}
