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
    private $sagePayApi;
    private $cardDetails;
    private $merchantSessionKey;

  public function __construct(CardDetails $cardDetails, MerchantSessionKey $merchantSessionKey)
  {
    $this->sagePayApi = new SagePayApi();
    $this->cardDetails = $cardDetails;
    $this->merchantSessionKey = $merchantSessionKey;
    $this->createCardIdentifier();
  }

  private function createCardIdentifier() {
    $cardIdentifier = $this->sagePayApi->createCardIdentifier($this->cardDetails, $this->merchantSessionKey);
    if (!empty($cardIdentifier) && !empty($cardIdentifier['expiry'] && !empty($cardIdentifier['cardIdentifier'] && !empty($cardIdentifier['cardType'])))) {
        $this->cardIdentifier = $cardIdentifier['cardIdentifier'];
        $this->expiry = $cardIdentifier['expiry'];
        $this->cardType = $cardIdentifier['cardType'];
    }
  }

  public function getCardIdentifier() : string {
    return $this->cardIdentifier;
  }

}
