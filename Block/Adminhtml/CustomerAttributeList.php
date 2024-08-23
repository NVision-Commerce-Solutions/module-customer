<?php

namespace Commerce365\Customer\Block\Adminhtml;

use Commerce365\Core\Service\Customer\GetParentCustomer;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Url;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class CustomerAttributeList extends Template
{
    private $customer;
    private CustomerInterfaceFactory $customerDataFactory;
    private DataObjectHelper $dataObjectHelper;
    private GetParentCustomer $getParentCustomer;
    private Url $urlBuilder;

    public function __construct(
        Context $context,
        CustomerInterfaceFactory $customerDataFactory,
        DataObjectHelper $dataObjectHelper,
        GetParentCustomer $getParentCustomer,
        Url $urlBuilder,
        array $data = []
    ) {
        $this->customerDataFactory = $customerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;

        parent::__construct($context, $data);
        $this->getParentCustomer = $getParentCustomer;
        $this->urlBuilder = $urlBuilder;
    }

    public function getCustomer()
    {
        if (!$this->customer) {
            $this->customer = $this->customerDataFactory->create();
            $data = $this->_backendSession->getCustomerData();
            $this->dataObjectHelper->populateWithArray(
                $this->customer,
                $data['account'],
                CustomerInterface::class
            );
        }
        return $this->customer;
    }

    public function getBcCustomerNo()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_customer_no')) {
            return $customer->getCustomAttribute('bc_customer_no')->getValue();
        }

        return '';
    }

    public function getBcContactNo()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_contact_no')) {
            return $customer->getCustomAttribute('bc_contact_no')->getValue();
        }

        return '';
    }

    public function getBcCustomerName()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_company_name')) {
            return $customer->getCustomAttribute('bc_company_name')->getValue();
        }

        return '';
    }

    public function getBcCustomerPriceGroup()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_customer_price_group')) {
            return $customer->getCustomAttribute('bc_customer_price_group')->getValue();
        }

        return '';
    }

    public function getBcCustomerDiscountGroup()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_customer_discount_group')) {
            return $customer->getCustomAttribute('bc_customer_discount_group')->getValue();
        }

        return '';
    }

    public function getBcPaymentTermsCode()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_payment_terms_code')) {
            return $customer->getCustomAttribute('bc_payment_terms_code')->getValue();
        }

        return '';
    }

    public function getBcPaymentMethodCode()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_payment_method_code')) {
            return $customer->getCustomAttribute('bc_payment_method_code')->getValue();
        }

        return '';
    }

    public function getBcShipmentMethodCode()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_shipment_method_code')) {
            return $customer->getCustomAttribute('bc_shipment_method_code')->getValue();
        }

        return '';
    }

    public function getBcShipmentAgentCode()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_shipment_agent_code')) {
            return $customer->getCustomAttribute('bc_shipment_agent_code')->getValue();
        }

        return '';
    }

    public function getBcShipmentAgentServiceCode()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_shipment_agent_service_code')) {
            return $customer->getCustomAttribute('bc_shipment_agent_service_code')->getValue();
        }

        return '';
    }

    public function getBcCustomerLocationCode()
    {
        $customer = $this->getCustomer();
        if ($customer->getCustomAttribute('bc_location_code')) {
            return $customer->getCustomAttribute('bc_location_code')->getValue();
        }

        return '';
    }

    public function getBcCustomerBlocked(): string
    {
        $customer = $this->getCustomer();
        if (!$customer->getCustomAttribute('bc_blocked_code')) {
            return '';
        }

        $blockedCode = $customer->getCustomAttribute('bc_blocked_code')->getValue();

        switch ($blockedCode) {
            case 0:
                return "None";
            case 1:
                return "Ship";
            case 2:
                return "Invoice";
            case 3:
                return "Ship & Invoice";
            default:
                return "Unknown";
        }
    }

    public function getParentCustomerUrl(): ?string
    {
        $parent = $this->getParentCustomer->execute($this->getCustomer());
        if ($parent->getId() === $this->getCustomer()->getId()) {
            return '';
        }

        return $this->urlBuilder->getUrl('*/*/edit', ['id' => $parent->getId()]);
    }

    public function getParentCustomerEmail(): string
    {
        $parent = $this->getParentCustomer->execute($this->getCustomer());
        if ($parent->getId() === $this->getCustomer()->getId()) {
            return '';
        }

        return $parent->getEmail();
    }
}
