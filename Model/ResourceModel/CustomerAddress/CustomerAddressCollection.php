<?php

declare(strict_types=1);

namespace Commerce365\Customer\Model\ResourceModel\CustomerAddress;

use Commerce365\Customer\Model\CustomerAddress as Model;
use Commerce365\Customer\Model\ResourceModel\CustomerAddress as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class CustomerAddressCollection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
