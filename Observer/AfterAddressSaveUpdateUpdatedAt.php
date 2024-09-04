<?php

declare(strict_types=1);

namespace Commerce365\Customer\Observer;

use Commerce365\Customer\Model\Command\UpdateCustomerUpdatedAtField;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Address;
use Psr\Log\LoggerInterface;

/**
 * Forces related customer_entity to update its updated_at field when addresses are updated
 */
class AfterAddressSaveUpdateUpdatedAt implements ObserverInterface
{
    private bool $updated = false;

    public function __construct(
        private readonly UpdateCustomerUpdatedAtField $updateCustomerUpdatedAtField,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer): void
    {
        /** @var Address $customerAddress */
        $customerAddress = $observer->getCustomerAddress();
        try {
            $customer = $customerAddress->getCustomer();
            $updatedAt = $customerAddress->getData('updated_at');
            $this->updateCustomerUpdatedAtField->execute($customer->getId(), $updatedAt);
        } catch (\Exception $e) {
            $this->logger->error("Failed to update customer updated_at field: " . $e->getMessage());
        }
    }
}
