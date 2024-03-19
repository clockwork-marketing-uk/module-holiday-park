<?php

namespace Clockwork\HolidayPark\SagePay;

use Clockwork\HolidayPark\Responses\PaymentResponse;
use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;
use Clockwork\HolidayPark\Interfaces\PaymentGatewayInterface;
use Clockwork\HolidayPark\SagePay\Purchase\PurchaseInfo;
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

  public function payment(CardDetails $cardDetails, CustomerDetails $customerDetails, PurchaseInfo $purchaseInfo): PaymentResponse
  {
    $this->createMerchantSessionKey();

    if ($this->merchantSessionKey->isValid()) {
      $this->createCardIdentifier($cardDetails);

      if ($this->cardIdentifier->isValid()) {
        $this->createCardTransaction($customerDetails, $purchaseInfo);

        if ($this->cardTransaction->isValid()) {
          return new PaymentResponse(true, "Success", $this->cardTransaction->transactionId);
        }
        return new PaymentResponse(false, "Couldn't create transaction", null, $this->cardTransaction->getErrors());
      }
      return new PaymentResponse(false, "Couldn't create card identifier", null, $this->cardIdentifier->getErrors());
    }
    return new PaymentResponse(
      false,
      "Couldn't create merchant session key",
      null,
      $this->merchantSessionKey->getErrors()
    );
  }

  private function createMerchantSessionKey()
  {
    $this->merchantSessionKey = new MerchantSessionKey();
  }

  private function createCardIdentifier(CardDetails $cardDetails)
  {
    $this->cardIdentifier = new CardIdentifier($cardDetails, $this->merchantSessionKey);
  }

  private function createCardTransaction(CustomerDetails $customerDetails, PurchaseInfo $purchaseInfo)
  {
    $this->cardTransaction = new CardTransaction($this->merchantSessionKey, $this->cardIdentifier, $customerDetails, $purchaseInfo);
  }
}
