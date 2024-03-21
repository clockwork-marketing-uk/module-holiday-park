<?php

namespace Clockwork\HolidayPark\Interfaces;

use Clockwork\HolidayPark\Responses\PaymentResponse;
use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Purchase\PurchaseInfo;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;
use Illuminate\Http\RedirectResponse;

interface PaymentGatewayInterface
{
  public function payment(CardDetails $cardDetails, CustomerDetails $customerDetails, PurchaseInfo $purchaseInfo) : PaymentResponse | RedirectResponse;
}