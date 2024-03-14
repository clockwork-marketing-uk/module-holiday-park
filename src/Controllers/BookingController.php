<?php

namespace Clockwork\HolidayPark\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\HolidayPark\Models\ParkBooking;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\HolidayPark\Services\HolidayParkApiService;
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
    $queryParams = $request->all();
    $accommodationId = $queryParams['id'] ?? null;
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
          
          // $booking = Cache::rememberForever('booking', function () use ($stay, $parkAccommodation, $queryParams) {
          //   return $this->createBooking($stay, $parkAccommodation->id, $queryParams);
          // });

          $booking = $this->createBooking($stay, $parkAccommodation->id, $queryParams);

          $extras = HolidayParkApiService::getExtras();

          return view("holidaypark::holiday-park.booking.book", [
            "parkAccommodation" => $parkAccommodation,
            "accommodation" => $accommodation,
            "stay" => $stay,
            "booking" => $booking,
            "extras" => $extras
          ]);
        }
      }
    }
    abort(404);
  }

  private function createBooking($stay, $parkAccommodationId, $queryParams) {
    $booking = HolidayParkApiService::createBooking();
    if ($booking) {
      $stay = (array) $stay;
      $standardAttributes = ["park_accommodation_id" => $parkAccommodationId, 'booking_no' => $booking->booking_no];
      $bookingAttributes = array_merge($standardAttributes, $stay, $queryParams);
      
      ParkBooking::create($bookingAttributes);
    }

    $parkBooking = HolidayParkApiService::getParkBooking($booking->booking_no);

    $response = null;
    if (!empty($parkBooking)) {
      $response = HolidayParkApiService::updateBookingAvailability($parkBooking);
    }

    return $booking;
  }

  public function validateBooking($queryParams)
  {
    if (!empty($queryParams['id'])) {
      unset($queryParams['id']);
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
        if (str_contains($paramName, 'date')) {
          $paramValue = EliteParks::formatSingleDate($paramValue);
        }
        if ($stay->{$paramName} !== $paramValue) {
          return false;
        }
      }
    }
    return true;
  }
}
