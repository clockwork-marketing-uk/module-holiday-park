<?php

namespace Clockwork\HolidayPark\Services;

use Clockwork\HolidayPark\SagePay\SagePay;
use Clockwork\HolidayPark\Responses\PaymentResponse;
use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Purchase\PurchaseInfo;
use Clockwork\HolidayPark\SagePay\Customer\BillingAddress;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;

class PaymentGatewayService
{
  private $paymentGateway;

  public function __construct()
  {
    $this->paymentGateway = new SagePay();
  }

  public static function makePayment($requestData, array $data) : PaymentResponse {
    $sagePay = new SagePay();
    $cardDetails = new CardDetails($requestData);
    $billingAddress = new BillingAddress($requestData);
    $customerDetails = new CustomerDetails(
      $requestData,
      $billingAddress
    );
    $purchaseInfo = new PurchaseInfo($data);

    return $sagePay->payment($cardDetails, $customerDetails, $purchaseInfo);
  }
}
