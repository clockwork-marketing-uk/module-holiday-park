<?php

namespace Clockwork\HolidayPark\SagePay\Customer;

class BillingAddress
{
  public $address1;
  public $address2;
  public $address3;
  public $city;
  public $postalCode;
  public $country;
  public $state;

  public function __construct(array $billingAddress)
  {
    $this->address1 = $billingAddress["address1"];
    $this->address2 = $billingAddress["address2"];
    $this->address3 = $billingAddress["address3"];
    $this->city = $billingAddress["city"];
    $this->postalCode = $billingAddress["postalCode"];
    $this->country = $billingAddress["country"];
    $this->state = $billingAddress["state"];
  }

  public function getBillingAddress(): array
  {
    return [
      "address1" => $this->address1,
      "address2" => $this->address2,
      "address3" => $this->address3,
      "city" => $this->city,
      "postalCode" => $this->postalCode,
      "country" => $this->country,
      "state" => $this->state,
    ];
  }
}
