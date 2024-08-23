<?php

declare(strict_types=1);

namespace Commerce365\Customer\Plugin;

use Commerce365\Customer\Service\SetExtensionAttributesToEntity;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\Address;

class AddressExtension
{
    public function __construct(private readonly SetExtensionAttributesToEntity $setExtensionAttributesToEntity) {}

    /**
     * @param Address $subject
     * @param AddressInterface $result
     * @param int|null $defaultBillingAddressId
     * @param int|null $defaultShippingAddressId
     * @return AddressInterface
     */
    public function afterGetDataModel(
        Address $subject,
        AddressInterface $result,
        $defaultBillingAddressId = null,
        $defaultShippingAddressId = null
    ): AddressInterface {
        return $this->setExtensionAttributesToEntity->execute($result);
    }
}
