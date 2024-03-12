<?php

namespace Clockwork\HolidayPark\Controllers\Api;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\Accommodation\Models\Accommodation;
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
}
