<?php

namespace Clockwork\HolidayPark\SagePay\Transaction;

use Clockwork\HolidayPark\SagePay\Api\SagePayApi;



class MerchantSessionKey
{
    public $merchantSessionKey;
    public $expiry;
    private $sagePayApi;

  public function __construct()
  {
    $this->sagePayApi = new SagePayApi();
    $this->createMerchantSessionKey();
  }

  private function createMerchantSessionKey() {
    $merchantKeyData = $this->sagePayApi->createMerchantSessionKey();
    if (!empty($merchantKeyData) && !empty($merchantKeyData['expiry'] && !empty($merchantKeyData['merchantSessionKey']))) {
        $this->merchantSessionKey = $merchantKeyData['merchantSessionKey'];
        $this->expiry = $merchantKeyData['expiry'];
    }
  }

  public function getMerchantSessionKey() : string {
    return $this->merchantSessionKey;
  }

}
