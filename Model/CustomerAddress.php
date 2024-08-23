<?php

declare(strict_types=1);

namespace Commerce365\Customer\Model;

use Commerce365\Customer\Api\Data\CustomerAddressInterface;
use Commerce365\Customer\Model\ResourceModel\CustomerAddress as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class CustomerAddress extends AbstractModel implements CustomerAddressInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getAddressId()
    {
        return $this->getData('address_id');
    }

    public function setAddressId($addressId)
    {
        return $this->setData('address_id', $addressId);
    }

    public function getSystemId()
    {
        return $this->getData('system_id');
    }

    public function setSystemId($systemId)
    {
        return $this->setData('system_id', $systemId);
    }

    public function getShipToCode()
    {
        return $this->getData('ship_to_code');
    }

    public function setShipToCode($shipToCode)
    {
        return $this->setData('ship_to_code', $shipToCode);
    }


}
