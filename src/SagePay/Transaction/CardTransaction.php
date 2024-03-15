<?php

namespace Clockwork\HolidayPark\SagePay\Transaction;

use Clockwork\HolidayPark\SagePay\Api\SagePayApi;
use Clockwork\HolidayPark\SagePay\Customer\CustomerDetails;
use Clockwork\HolidayPark\SagePay\Transaction\CardIdentifier;
use Clockwork\HolidayPark\SagePay\Transaction\MerchantSessionKey;




class CardTransaction
{
  public $transactionId;
  private $sagePayApi;
  private $merchantSessionKey;
  private $customerDetails;
  private $cardIdentifier;


  public function __construct(MerchantSessionKey $merchantSessionKey, CardIdentifier $cardIdentifier, CustomerDetails $customerDetails)
  {
    $this->merchantSessionKey = $merchantSessionKey;
    $this->cardIdentifier = $cardIdentifier;
    $this->customerDetails = $customerDetails;

    $this->sagePayApi = new SagePayApi();
    $this->createCardTransaction();
  }

  private function createCardTransaction() {
    $cardTransaction = $this->sagePayApi->createCardTransaction($this->merchantSessionKey, $this->cardIdentifier, $this->customerDetails);
    dd($cardTransaction);
    if (!empty($cardTransaction) && !empty($cardTransaction['transactionId'] && !empty($cardTransaction['status']))) {
       if($cardTransaction['status'] == "Ok") {
        $this->transactionId = $cardTransaction['transactionId'];
       }
    }
  }



}
