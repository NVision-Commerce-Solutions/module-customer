<?php

namespace Commerce365\Customer\Api\Data;

interface CustomerAddressInterface
{
    public const ENTITY_ID = 'entity_id';
    public const ADDRESS_ID = 'address_id';
    public const SYSTEM_ID = 'system_id';
    public const SHIP_TO_CODE = 'ship_to_code';

    public function getEntityId();
    public function setEntityId($entityId);

    public function getAddressId();
    public function setAddressId($addressId);

    public function getSystemId();
    public function setSystemId($systemId);

    public function getShipToCode();
    public function setShipToCode($shipToCode);
}
