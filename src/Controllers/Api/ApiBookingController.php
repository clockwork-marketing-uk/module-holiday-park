<?php

namespace Clockwork\HolidayPark\Controllers\Api;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\HolidayPark\Models\ParkBooking;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Services\HolidayParkApiService;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;

class ApiBookingController extends CmsController
{
  private $holidayParkService;

  public function __construct(HolidayParkApiService $holidayParkService)
  {
    $this->holidayParkService = $holidayParkService;
    $this->module = "holidaypark";
  }
  
  public function createBooking() {
    return $this->holidayParkService::createBooking();
  }

  public function updateExtras(Request $request) {
    $booking_no = $request?->booking_no;
    $extras = $request?->data;
    $extrasWithPrices = null;
    if (!empty($booking_no) && !empty($extras)) {
      $extrasWithPrices = HolidayParkApiService::updateExtras($booking_no, $extras);
    }
    
    return response()->json([
      "extrasWithPrices" => $extrasWithPrices,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function getBooking(Request $request) {
    $booking_no = $request?->booking_no;
    $booking = null;
    if (!empty($booking_no)) {
      $booking = HolidayParkApiService::getBooking($booking_no);
    }
    
    return response()->json([
      "booking" => $booking,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function updateContact(Request $request) {
    $booking_no = $request?->booking_no;
    $contactInfo = $request?->data;

    $response = null;
    if (!empty($booking_no) && !empty($contactInfo)) {
      $response = HolidayParkApiService::updateContact($booking_no, $contactInfo);
    }
    
    return response()->json([
      "response" => $response,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function updateBookingAvailability(Request $request) {
    $booking_no = $request?->booking_no;

    $parkBooking = HolidayParkApiService::getParkBooking($booking_no);

    $response = null;
    if (!empty($booking_no) && !empty($parkBooking)) {
      $response = HolidayParkApiService::updateBookingAvailability($parkBooking);
    }
    
    return response()->json([
      "response" => $response,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function getMasterBookingExtras(Request $request) {
    return HolidayParkApiService::getMasterBookingExtras();
  }

  public function tagBooking(Request $request) {
    $booking_no = $request?->booking_no;
    $booking = null;
    if (!empty($booking_no)) {
      $booking = HolidayParkApiService::tagBooking($booking_no);
    }
    
    return response()->json([
      "booking" => $booking,
      "csrf_token" => csrf_token(),
    ]);
  }
}
