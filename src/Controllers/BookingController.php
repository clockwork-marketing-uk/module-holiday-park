<?php

namespace Clockwork\HolidayPark\Controllers;

use Illuminate\Http\Request;
use Clockwork\Core\Models\Base;
use Clockwork\Pages\Models\Page;
use Illuminate\Support\Facades\Log;
use Clockwork\Core\Helpers\TagParser;
use Clockwork\Settings\Helpers\Setting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\HolidayPark\Models\ParkBooking;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\HolidayPark\Services\HolidayParkApiService;
use Clockwork\HolidayPark\Services\PaymentGatewayService;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;

class BookingController extends CmsController
{
  private $parkAccommodationRepository;

  public function __construct(ParkAccommodationRepository $parkAccommodationRepository)
  {
    $this->parkAccommodationRepository = $parkAccommodationRepository;
    $this->module = "holidaypark";
  }

  public function book(Request $request)
  {
    // dd($request);
    $queryParams = $request->all();
    $accommodationId = $queryParams["id"] ?? null;
    if (!empty($accommodationId)) {
      $parkAccommodation = HolidayParkApiService::getParkAccommodationByAccommodationId($accommodationId);
      $accommodation = Accommodation::find($accommodationId);

      if (!empty($parkAccommodation) && !empty($accommodation)) {
        $stay = $this->validateBooking($queryParams);

        if ($stay) {
          // return view($this->getViewName("holiday-park.booking.book"), [
          //   "parkAccommodation" => $parkAccommodation,
          //   "accommodation" => $accommodation,
          //   "stay" => $stay
          // ]);

          $booking = $this->createBooking($stay, $parkAccommodation->id, $queryParams);

          $extras = HolidayParkApiService::getExtras();

          $confirmationPage = $this->findConfirmationPage();


          return view("holidaypark::holiday-park.booking.book", [
            "parkAccommodation" => $parkAccommodation,
            "accommodation" => $accommodation,
            "stay" => $stay,
            "booking" => $booking,
            "extras" => $extras,
            "confirmationPage" => $confirmationPage
          ]);
        }
      }
    }
    abort(404);
  }

  private function findConfirmationPage()
  {
    $confirmationPageDynamicLink = app(Setting::class)->get("park_confirmation_page") ?? "";
    if (!empty($confirmationPageDynamicLink)) {
      $confirmationPageUrl = TagParser::parse($confirmationPageDynamicLink);
      if (!empty($confirmationPageUrl)) {
        $confirmationPageBase = Base::where('url', '=', $confirmationPageUrl)->first() ?? null;
        return Page::find($confirmationPageBase->baseable_id) ?? null;
      }
    }
    return null;
  }

  private function createBooking($stay, $parkAccommodationId, $queryParams)
  {
    $booking = HolidayParkApiService::createBooking();
    if ($booking) {
      $stay = (array) $stay;
      $standardAttributes = ["park_accommodation_id" => $parkAccommodationId, "booking_no" => $booking->booking_no];
      $bookingAttributes = array_merge($standardAttributes, $stay, $queryParams);

      ParkBooking::create($bookingAttributes);
    }

    $parkBooking = HolidayParkApiService::getParkBooking($booking->booking_no);

    $response = null;
    if (!empty($parkBooking)) {
      $response = HolidayParkApiService::updateBookingAvailability($parkBooking);
    }
    return $parkBooking;
  }

  public function validateBooking($queryParams)
  {
    if (!empty($queryParams["id"])) {
      unset($queryParams["id"]);
    }

    $availability = EliteParks::findAvailability($queryParams)->getData();

    if (!empty($availability) && !empty($availability?->data?->Result)) {
      foreach ($availability->data->Result as $stay) {
        if ($stay?->{'@attributes'}) {
          if ($this->queryParamsMatchStay($stay->{'@attributes'}, $queryParams)) {
            return $stay->{'@attributes'};
          }
        }
      }
    }

    return false;
  }

  private function queryParamsMatchStay($stay, $queryParams)
  {
    foreach ($queryParams as $paramName => $paramValue) {
      if (property_exists($stay, $paramName)) {
        if (str_contains($paramName, "date")) {
          $paramValue = EliteParks::formatSingleDate($paramValue);
        }
        if ($stay->{$paramName} !== $paramValue) {
          return false;
        }
      }
    }
    return true;
  }

  public function beginPayment(Request $request)
  {
    $request->validate([
      'cardNumber' => 'required|digits_between:15,19',
      'expiryDate' => 'required|digits:4',
      'cardholderName' => 'required',
      'securityCode' => 'required|digits_between:3,4',

      'customerFirstName' => 'required',
      'customerLastName' => 'required',
      'customerEmail' => 'required',
      'customerPhone' => 'required',

      'city' => 'required',
      'postalCode' => 'required',
      'address1' => 'required',
    ]);

    $bookingNo = $request->booking_no;
    $booking = HolidayParkApiService::getBooking($bookingNo);
    $booking = $booking['booking'];
    $totalPrice = $booking->total_price;
    $booking->reference = $booking->booking_no;
    $booking = (array) $booking;

    $payment = PaymentGatewayService::makePayment($request->all(), $booking);


    if ($this->needs3dSecureRedirect($payment)) {
      return $payment->data->redirect3DSecure;
    }

    if ($payment->valid) {
      HolidayParkApiService::bookingSuccess($bookingNo, $totalPrice);
      return $this->redirectToSuccessPage();
    }

    if (!$payment->valid) {
      if (!empty($payment->data->errors)) {
        return Redirect::back()->withErrors($payment->data->errors);
      }
      HolidayParkApiService::bookingFailed($bookingNo);
      return $this->redirectToFailedPage();
    }

    return redirect('/contact');
  }

  private function validatePaymentRequest(Request $request)
  {

  }

  private function redirectToSuccessPage()
  {
    $bookingSuccessPageDynamicLink = app(Setting::class)->get("park_booking_success");
    if (!empty($bookingSuccessPageDynamicLink)) {
      $bookingSuccessPageUrl = TagParser::parse($bookingSuccessPageDynamicLink);
      if (!empty($bookingSuccessPageUrl)) {
        return redirect($bookingSuccessPageUrl);
      }
    }
  }

  private function redirectToFailedPage()
  {
    $bookingFailedPageDynamicLink = app(Setting::class)->get("park_booking_failed");
    if (!empty($bookingFailedPageDynamicLink)) {
      $bookingFailedPageUrl = TagParser::parse($bookingFailedPageDynamicLink);
      if (!empty($bookingFailedPageUrl)) {
        return redirect($bookingFailedPageUrl);
      }
    }
  }

  public function threeDSecureReceiveResponse(Request $request)
  {
    $requestData = $request->all();
    $decodedSessionData = base64_decode($requestData['threeDSSessionData']);
    parse_str($decodedSessionData, $sessionData);

    if (!empty($requestData['cres']) && !empty($sessionData['transactionId'] && !empty($sessionData['bookingId']))) {
      $secure = PaymentGatewayService::confirm3DSecure($sessionData['transactionId'], $requestData['cres']);
      if ($secure?->valid && !empty($secure?->data['amount']['totalAmount'])) {
        HolidayParkApiService::bookingSuccess($sessionData['bookingId'], $secure->data['amount']['totalAmount']);
        return $this->redirectToSuccessPage();
      } else {
        HolidayParkApiService::bookingFailed($sessionData['bookingId']);
        return $this->redirectToFailedPage();
      }
    }
    return redirect('/contact');
  }

  private function needs3dSecureRedirect($payment)
  {
    return !empty($payment->data->redirect3DSecure);
  }

  public function threeDSecureStart(Request $request)
  {
    return view('holidaypark::holiday-park.booking.3d-secure.start', $request->all());
  }
}
