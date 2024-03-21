<?php

namespace Clockwork\HolidayPark\SagePay;

use stdClass;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Clockwork\HolidayPark\SagePay\Api\SagePayApi;
use Clockwork\HolidayPark\Responses\PaymentResponse;
use Clockwork\HolidayPark\SagePay\Customer\CardDetails;
use Clockwork\HolidayPark\SagePay\Purchase\PurchaseInfo;
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

  public function payment(CardDetails $cardDetails, CustomerDetails $customerDetails, PurchaseInfo $purchaseInfo): PaymentResponse
  {
    $this->createMerchantSessionKey();

    if ($this->merchantSessionKey->isValid()) {
      $this->createCardIdentifier($cardDetails);

      if ($this->cardIdentifier->isValid()) {
        $this->createCardTransaction($customerDetails, $purchaseInfo);

        if ($this->cardTransaction->isValid()) {
          return new PaymentResponse(true, "Success", $this->cardTransaction->transactionId, null, $this->cardTransaction);
        }
        else if (!empty($this->cardTransaction->response->data['statusCode'])) {
          if ($this->cardTransaction->response->data['statusCode'] == 2021) {
            return $this->redirectToAcsUrl($this->cardTransaction->response->data, $purchaseInfo);
          }
        }
        return new PaymentResponse(false, "Couldn't create transaction", null, null, $this->cardTransaction->response->data);
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

  private function redirectToAcsUrl(array $data, PurchaseInfo $purchaseInfo) {
    $acsUrl = $data['acsUrl'] ?? "";
    $cReq = $data['cReq'] ?? "";

    $data = [
      "creq" => $cReq,
      "acsUrl" => $acsUrl,
      "threeDSSessionData" => [
        'transactionId' => $data['transactionId'] ?? "",
        'bookingId' => $purchaseInfo->reference ?? "",
      ]
    ];

    $redirect = new stdClass();
    $redirect->redirect3DSecure = Redirect::route('holiday-park.booking.3d-secure-start', $data);

    return new PaymentResponse(false, "Redirect To ACS URL for 3D Secure", null, null, $redirect);
  }

  public function confirm3DSecure($transactionId, $cRes) {
    $sagePayApi = new SagePayApi();

    $response = $sagePayApi->secureChallenge($cRes, $transactionId);

    if ($response->valid && !empty($response->data['transactionId'])) {
      return new PaymentResponse(true, "Success", $response->data['transactionId'], null, $response->data);
    }
  }
}
