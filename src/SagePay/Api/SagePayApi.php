<?php

namespace Clockwork\HolidayPark\SagePay\Api;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Clockwork\HolidayPark\Responses\ApiResponse;
use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Purchase\PurchaseInfo;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;
use Clockwork\HolidayPark\SagePay\Transaction\CardIdentifier;
use Clockwork\HolidayPark\Responses\PaymentGatewayApiResponse;
use Clockwork\HolidayPark\SagePay\Transaction\MerchantSessionKey;

class SagePayApi
{
  private $endpoint;
  private $vendorName;
  private $integrationKey;
  private $integrationPassword;
  public function __construct()
  {
    $this->endpoint = env('SAGE_PAY_BASE_URL') ?? "";
    $this->vendorName = env('SAGE_PAY_VENDOR_NAME') ?? "";
    $this->integrationKey = env('SAGE_PAY_INTEGRATION_KEY') ?? "";
    $this->integrationPassword = env('SAGE_PAY_INTEGRATION_PASSWORD') ?? "";
  }

  public function createMerchantSessionKey(): PaymentGatewayApiResponse
  {
    $queryUrl = 'merchant-session-keys';
    $response = Http::withBasicAuth($this->integrationKey, $this->integrationPassword)->post($this->endpoint . "$queryUrl", [
      'vendorName' => $this->vendorName,
    ]);
    if ($response->successful()) {
      $responseJson = $response->json();
      if (!empty($responseJson) && !empty($responseJson['expiry'] && $responseJson['merchantSessionKey'])) {
        return new PaymentGatewayApiResponse(true, $responseJson, 'Success');
      }
    } else {
      return new PaymentGatewayApiResponse(false, null, 'Response missing merchant session key', $response->json());
    }
    return new PaymentGatewayApiResponse(false, null, 'Missing merchant key!', $response->json());
  }

  public function createCardIdentifier(CardDetails $cardDetails, MerchantSessionKey $merchantSessionKey): PaymentGatewayApiResponse
  {
    $queryUrl = 'card-identifiers';
    $cardDetails = $cardDetails->getCardDetails();
    $cardDetails['vendorName'] = $this->vendorName;
    $data = ['cardDetails' => $cardDetails];
    $response = Http::withToken($merchantSessionKey->getMerchantSessionKey())->post($this->endpoint . "$queryUrl", $data);
    if ($response->successful()) {
      $responseJson = $response->json();
      if (!empty($responseJson) && !empty($responseJson['expiry'] && $responseJson['cardIdentifier'])) {
        return new PaymentGatewayApiResponse(true, $responseJson, 'Success');
      }
    } else {
      Log::info($response->json());
      return new PaymentGatewayApiResponse(false, null, 'Missing card identifier in response', $response->json());
    }
    return new PaymentGatewayApiResponse(false, null, 'Missing card identifier!', $response->json());
  }

  public function createCardTransaction(MerchantSessionKey $merchantSessionKey, CardIdentifier $cardIdentifier, CustomerDetails $customerDetails, PurchaseInfo $purchaseInfo): PaymentGatewayApiResponse
  {
    $queryUrl = 'transactions';
    try {
      $totalPrice = (float) $purchaseInfo->total_price;
    }
    catch (Exception $e) {
      $totalPrice = null;
    }

    if (empty($totalPrice)) {
      return new PaymentGatewayApiResponse(false, null, 'Price not included in transaction', []);
    }
    
    $data = [
      'transactionType' => 'Payment',
      'vendorName' => $this->vendorName,
      'paymentMethod' => [
        'card' => [
          'merchantSessionKey' => $merchantSessionKey->getMerchantSessionKey(),
          'cardIdentifier' => $cardIdentifier->getCardIdentifier(),
          'reusable' => false,
          'save' => true,
        ],
      ],
      'vendorTxCode' => uniqid(),
      'amount' => $totalPrice,
      'currency' => 'GBP',
      'description' => 'Transaction Description',
      '3DSecure' => [
        'status' => 'IssuerNotEnrolled',
      ],
      'apply3DSecure' => 'force',
    ];

    $data = array_merge($data, $customerDetails->getCustomerDetails());

    $response = Http::withBasicAuth($this->integrationKey, $this->integrationPassword)->post($this->endpoint . "$queryUrl", $data);
    if ($response->successful()) {
      $responseJson = $response->json();
      if (!empty($responseJson) && !empty($responseJson['transactionId'] && $responseJson['status'])) {
        return new PaymentGatewayApiResponse(true, $responseJson, 'Success');
      }
    } else {
      Log::info($response->json());
      return new PaymentGatewayApiResponse(false, null, 'Missing transactionId in response', $response->json());
    }
    return new PaymentGatewayApiResponse(false, null, 'Missing create transaction', $response->json());
  }
}
