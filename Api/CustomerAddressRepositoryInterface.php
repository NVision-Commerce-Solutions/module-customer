<?php

namespace Commerce365\Customer\Api;

use Commerce365\Customer\Api\Data\CustomerAddressInterface;

interface CustomerAddressRepositoryInterface
{
    public function save(CustomerAddressInterface $customAttribute);
    public function getByAddressId($addressId);
    public function delete(CustomerAddressInterface $customAttribute);
    public function deleteById($entityId);
}
