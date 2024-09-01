<?php

declare(strict_types=1);

namespace Commerce365\Customer\Plugin;

use Commerce365\Customer\Api\CustomerAddressRepositoryInterface;
use Commerce365\Customer\Model\CustomerAddressFactory;
use Commerce365\Customer\Service\SetExtensionAttributesToEntity;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressSearchResultsInterface;

class CustomerAddressRepositoryExtension
{
    public function __construct(
        private readonly SetExtensionAttributesToEntity $setExtensionAttributesToEntity,
        private readonly CustomerAddressRepositoryInterface $customerAddressRepository,
        private readonly CustomerAddressFactory $customerAddressFactory
    ) {}

    public function afterGet(AddressRepositoryInterface $subject, AddressInterface $entity)
    {
        return $this->setExtensionAttributesToEntity->execute($entity);
    }

    public function afterGetList(
        AddressRepositoryInterface $subject,
        AddressSearchResultsInterface $searchResults
    ) : AddressSearchResultsInterface
    {
        $addresses = [];
        foreach ($searchResults->getItems() as $entity) {
            $entity = $this->setExtensionAttributesToEntity->execute($entity);

            $addresses[] = $entity;
        }
        $searchResults->setItems($addresses);
        return $searchResults;
    }

    public function afterSave(AddressRepositoryInterface $subject, AddressInterface $result, AddressInterface $entity)
    {
        $systemId = $entity->getExtensionAttributes()->getSystemId();
        $shipToCode = $entity->getExtensionAttributes()->getShipToCode();
        $customerAddress = $this->customerAddressRepository->getByAddressId($entity->getId());

        if (!$customerAddress->getId()) {
            $customerAddress = $this->customerAddressFactory->create();
            $customerAddress->setAddressId($entity->getId());
        }

        $customerAddress->setSystemId($systemId);
        $customerAddress->setShipToCode($shipToCode);
        $this->customerAddressRepository->save($customerAddress);

        return $result;
    }
}
