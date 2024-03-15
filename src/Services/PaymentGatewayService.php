<?php

namespace Clockwork\HolidayPark\Services;

use Clockwork\HolidayPark\SagePay\SagePay;

class PaymentGatewayService
{
  private $paymentGateway;

  public function __construct()
  {
    $this->paymentGateway = new SagePay();
  }

}
