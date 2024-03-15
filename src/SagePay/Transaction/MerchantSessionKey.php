<?php

namespace Clockwork\HolidayPark\SagePay\Transaction;

use Clockwork\HolidayPark\SagePay\Api\SagePayApi;
use Clockwork\HolidayPark\Interfaces\PaymentGatewayValidationInterface;

class MerchantSessionKey implements PaymentGatewayValidationInterface
{
  public $merchantSessionKey;
  public $expiry;
  public $valid = false;
  private $sagePayApi;
  private $errors;

  public function __construct()
  {
    $this->sagePayApi = new SagePayApi();
    $this->createMerchantSessionKey();
  }

  private function createMerchantSessionKey()
  {
    $paymentGatewayResponse = $this->sagePayApi->createMerchantSessionKey();
    if ($paymentGatewayResponse->valid) {
      $merchantSessionKeyData = $paymentGatewayResponse->getData();
      if (!empty($merchantSessionKeyData) && !empty($merchantSessionKeyData["expiry"] && !empty($merchantSessionKeyData["merchantSessionKey"]))) {
        $this->merchantSessionKey = $merchantSessionKeyData["merchantSessionKey"];
        $this->expiry = $merchantSessionKeyData["expiry"];
        $this->valid = true;
      }
    }
    else {
      $this->errors = $paymentGatewayResponse->errors;
    }
  }

  public function getMerchantSessionKey(): string|null
  {
    return $this->merchantSessionKey;
  }

  public function getErrors() : array
  {
    return $this->errors;
  }

  public function isValid() : bool {
    return $this->valid && !empty($this->merchantSessionKey);
  }
}
