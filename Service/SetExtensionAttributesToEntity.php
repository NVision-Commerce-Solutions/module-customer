<?php

declare(strict_types=1);

namespace Commerce365\Customer\Service;

use Commerce365\Customer\Api\CustomerAddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;

class SetExtensionAttributesToEntity
{
    public function __construct(private readonly CustomerAddressRepositoryInterface $customerAddressRepository) {}

    public function execute(AddressInterface $entity)
    {
        $customerAddress = $this->customerAddressRepository->getByAddressId($entity->getId());

        $extensionAttributes = $entity->getExtensionAttributes();

        if ($extensionAttributes) {
            $extensionAttributes->setSystemId($customerAddress->getSystemId());
            $extensionAttributes->setShipToCode($customerAddress->getShipToCode());
            $entity->setExtensionAttributes($extensionAttributes);
        }

        return $entity;
    }
}
