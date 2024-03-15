<?php

namespace Clockwork\HolidayPark\SagePay\Customer;

class CustomerDetails
{
  public $customerFirstName;
  public $customerLastName;
  public $billingAddress;
  public $customerEmail;
  public $customerPhone;

  public function __construct(array $customerDetails, BillingAddress $billingAddress)
  {
    $this->customerFirstName = $customerDetails["customerFirstName"];
    $this->customerLastName = $customerDetails["customerLastName"];
    $this->billingAddress = $billingAddress->getBillingAddress();
    $this->customerEmail = $customerDetails["customerEmail"];
    $this->customerPhone = $customerDetails["customerPhone"];
  }

  public function getCustomerDetails(): array
  {
    return [
      "customerFirstName" => $this->customerFirstName,
      "customerLastName" => $this->customerLastName,
      "billingAddress" => $this->billingAddress,
      "customerEmail" => $this->customerEmail,
      "customerPhone" => $this->customerPhone,
    ];
  }
}
