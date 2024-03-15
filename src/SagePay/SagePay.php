<?php

namespace Clockwork\HolidayPark\SagePay;

use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;
use Clockwork\HolidayPark\Interfaces\PaymentGatewayInterface;
use Clockwork\HolidayPark\SagePay\Transaction\CardIdentifier;
use Clockwork\HolidayPark\SagePay\Transaction\CardTransaction;
use Clockwork\HolidayPark\SagePay\Transaction\MerchantSessionKey;

class SagePay implements PaymentGatewayInterface
{
  private $merchantSessionKey;
  private $cardIdentifier;
  private $cardTransaction;

  public function __construct()
  {

  }

  public function payment(CardDetails $cardDetails, CustomerDetails $customerDetails) {
    $this->createMerchantSessionKey();

    if (!empty($this->merchantSessionKey)) {
      $this->createCardIdentifier($cardDetails);
      if (!empty($this->cardIdentifier)) {
        $this->createCardTransaction($customerDetails);
      }
    }
    else {

    }
    
  }

  private function sanitizeCardDetails($cardDetails) {
    
  }

  private function createMerchantSessionKey() {
    $this->merchantSessionKey = new MerchantSessionKey();
  }

  private function createCardIdentifier(CardDetails $cardDetails)  {
    $this->cardIdentifier = new CardIdentifier($cardDetails, $this->merchantSessionKey);
  }

  private function createCardTransaction(CustomerDetails $customerDetails) {
    $this->cardTransaction = new CardTransaction($this->merchantSessionKey, $this->cardIdentifier, $customerDetails);
  }

}
