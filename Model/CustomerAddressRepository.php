<?php

declare(strict_types=1);

namespace Commerce365\Customer\Model;

use Commerce365\Customer\Api\CustomerAddressRepositoryInterface;
use Commerce365\Customer\Api\Data\CustomerAddressInterface;
use Commerce365\Customer\Model\ResourceModel\CustomerAddress as ResourceModel;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;

class CustomerAddressRepository implements CustomerAddressRepositoryInterface
{
    public function __construct(
        private readonly ResourceModel $resource,
        private readonly CustomerAddressFactory $customerAddressFactory,
        private readonly ResourceModel\CustomerAddressCollectionFactory $customerAddressCollectionFactory
    ) {}

    /**
     * @param CustomerAddressInterface $customerAddress
     * @return CustomerAddressInterface
     * @throws CouldNotSaveException
     */
    public function save(CustomerAddressInterface $customerAddress)
    {
        try {
            $this->resource->save($customerAddress);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $customerAddress;
    }

    /**
     * @param $addressId
     * @return mixed
     */
    public function getByAddressId($addressId)
    {
        $collection = $this->customerAddressCollectionFactory->create();
        $collection->addFieldToFilter('address_id', $addressId);

        return $collection->getFirstItem();
    }

    /**
     * @param CustomerAddressInterface $customerAddress
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete(CustomerAddressInterface $customerAddress): bool
    {
        try {
            $this->resource->delete($customerAddress);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @param $entityId
     * @return true
     * @throws CouldNotDeleteException
     */
    public function deleteById($entityId)
    {
        $customerAddress = $this->customerAddressFactory->create();
        $customerAddress->load($entityId);

        return $this->delete($customerAddress);
    }
}
