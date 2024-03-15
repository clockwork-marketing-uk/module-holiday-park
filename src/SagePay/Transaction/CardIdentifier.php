<?php

namespace Clockwork\HolidayPark\SagePay\Transaction;

use Clockwork\HolidayPark\SagePay\Api\SagePayApi;
use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Transaction\MerchantSessionKey;

class CardIdentifier
{
    public $cardIdentifier;
    public $expiry;
    public $cardType;
    private $valid = false;
    private $sagePayApi;
    private $cardDetails;
    private $merchantSessionKey;
    private $errors;

  public function __construct(CardDetails $cardDetails, MerchantSessionKey $merchantSessionKey)
  {
    $this->sagePayApi = new SagePayApi();
    $this->cardDetails = $cardDetails;
    $this->merchantSessionKey = $merchantSessionKey;
    $this->createCardIdentifier();
  }

  private function createCardIdentifier() {
    $paymentGatewayResponse = $this->sagePayApi->createCardIdentifier($this->cardDetails, $this->merchantSessionKey);
    if ($paymentGatewayResponse->valid) {
      $cardIdentifierData = $paymentGatewayResponse->getData();
      if (!empty($cardIdentifierData) && !empty($cardIdentifierData["cardIdentifier"])) {
        $this->cardIdentifier = $cardIdentifierData['cardIdentifier'];
        $this->expiry = $cardIdentifierData['expiry'];
        $this->cardType = $cardIdentifierData['cardType'];
        $this->valid = true;
      }
    }
    else {
      $this->errors = $paymentGatewayResponse->errors;
    }
  }

  public function getCardIdentifier() : string | null {
    return $this->cardIdentifier;
  }

  public function isValid() : bool {
    return $this->valid && !empty($this->cardIdentifier);
  }

  public function getErrors()
  {
    return $this->errors;
  }

}
