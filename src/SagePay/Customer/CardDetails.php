<?php

namespace Clockwork\HolidayPark\SagePay\Customer;

class CardDetails
{
  public $cardholderName;
  public $cardNumber;
  public $expiryDate;
  public $securityCode;

  public function __construct(array $cardDetails)
  {
    $this->cardholderName = $cardDetails["cardholderName"];
    $this->cardNumber = $cardDetails["cardNumber"];
    $this->expiryDate = $cardDetails["expiryDate"];
    $this->securityCode = $cardDetails["securityCode"];
  }

  public function getCardDetails(): array
  {
    return [
      "cardholderName" => $this->cardholderName,
      "cardNumber" => $this->cardNumber,
      "expiryDate" => $this->expiryDate,
      "securityCode" => $this->securityCode,
    ];
  }
}
