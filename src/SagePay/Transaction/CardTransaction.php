<?php

namespace Clockwork\HolidayPark\SagePay\Transaction;

use Clockwork\HolidayPark\SagePay\Api\SagePayApi;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;
use Clockwork\HolidayPark\SagePay\Purchase\PurchaseInfo;
use Clockwork\HolidayPark\SagePay\Transaction\CardIdentifier;
use Clockwork\HolidayPark\SagePay\Transaction\MerchantSessionKey;
use Clockwork\HolidayPark\Interfaces\PaymentGatewayValidationInterface;




class CardTransaction implements PaymentGatewayValidationInterface
{
  public $transactionId;
  public $response;
  private $sagePayApi;
  private $merchantSessionKey;
  private $customerDetails;
  private $cardIdentifier;
  private $purchaseInfo;
  private $valid = false;
  private $errors;


  public function __construct(MerchantSessionKey $merchantSessionKey, CardIdentifier $cardIdentifier, CustomerDetails $customerDetails, PurchaseInfo $purchaseInfo)
  {
    $this->merchantSessionKey = $merchantSessionKey;
    $this->cardIdentifier = $cardIdentifier;
    $this->customerDetails = $customerDetails;
    $this->sagePayApi = new SagePayApi();
    $this->purchaseInfo = $purchaseInfo;
    $this->createCardTransaction();
  }

  private function createCardTransaction() {
    $paymentGatewayResponse = $this->sagePayApi->createCardTransaction($this->merchantSessionKey, $this->cardIdentifier, $this->customerDetails, $this->purchaseInfo);
    $this->response = $paymentGatewayResponse;
    // dd($paymentGatewayResponse->getData());
    if ($paymentGatewayResponse->valid) {
      $cardTransactionData = $paymentGatewayResponse->getData();
      if (!empty($cardTransactionData) && !empty($cardTransactionData['transactionId'] && !empty($cardTransactionData['status']))) {
        if($cardTransactionData['status'] == "Ok") {
          $this->transactionId = $cardTransactionData['transactionId'];
          $this->valid = true;
         }
      }
    }
    else {
      $this->errors = $paymentGatewayResponse->errors;
    }
  }

  public function isValid() : bool {
    return $this->valid && !empty($this->transactionId);
  }

  public function getErrors() : array
  {
    return $this->errors;
  }

}
