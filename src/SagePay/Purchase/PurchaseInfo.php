<?php

namespace Clockwork\HolidayPark\SagePay\Purchase;

class PurchaseInfo
{
  public $reference;
  public $total_price;

  public function __construct(array $purchaseInfo)
  {
    $this->reference = $purchaseInfo["reference"];
    $this->total_price = $purchaseInfo["total_price"];
  }

  public function getBookingInfo(): array
  {
    return [
      "reference" => $this->reference,
      "total_price" => $this->total_price,
    ];
  }
}
