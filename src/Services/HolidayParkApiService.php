<?php

namespace Clockwork\HolidayPark\Services;

use Clockwork\EliteParks\Models\Property;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\EliteParks\Models\MasterBookingExtra;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Models\ParkAccommodationable;
use Clockwork\HolidayPark\Interfaces\HolidayParkApiInterface;

class HolidayParkApiService implements HolidayParkApiInterface
{
  private $api;
  public function __construct()
  {
    $this->api = "elite";
  }
  public function getAccommodationData()
  {
    switch ($this->api) {
      case "elite":
        $accommodationData = EliteParks::getSetup();
        break;
      default:
        $accommodationData = collect([]);
        break;
    }

    return $accommodationData;
  }
  public static function findAvailability($params)
  {
    return EliteParks::findAvailability($params);
  }

  public static function getProperties()
  {
    return Property::all();
  }

  public static function getParkAccommodationByAccommodationId($accommodationId)
  {
    $parkAccommodationable = ParkAccommodationable::where("park_accommodationable_id", $accommodationId)
      ->where("park_accommodationable_type", Accommodation::class)
      ->first();

    $parkAccommodation = null;
    if (!empty($parkAccommodationable)) {
      $parkAccommodation = ParkAccommodation::where("id", "=", $parkAccommodationable->park_accommodation_id)->first();
    }

    return $parkAccommodation;
  }

  public static function createBooking()
  {
    $booking = EliteParks::createBooking();
    if ($booking->getData()?->message == "ok") {
      return $booking->getData()?->data?->{'@attributes'}?->booking_no ?? null;
    }
    return null;
  }

  public static function getBooking($booking)
  {
    return EliteParks::getBooking($booking)->getData()?->data?->{'@attributes'} ?? null;
  }

  public static function getExtras()
  {
    $extras = EliteParks::getExtras()->where("mandatory", "=", "false");
    $oneOffs = [];
    $perNights = [];

    if (!empty($extras)) {
      foreach (EliteParks::getExtras() as $extra) {
        if ($extra->pricing_method_type == "One-Off" && $extra->maximum_quantity > 0) {
          $oneOffs[] = $extra;
        }
        if ($extra->pricing_method_type == "Per Night") {
          $perNights[] = $extra;
        }
      }
    }

    return ["oneOffs" => $oneOffs, "perNights" => $perNights];
  }

  public static function updateExtras($booking_no, $extras) {
    if ( !empty($booking_no) && !empty($extras) ) {
      $response = EliteParks::updateExtras($booking_no, $extras);
      if (!empty($response)) {
        return $response;
      } 
    }
    return null;
  }

  public static function updateContact($booking_no, $contactInfo) {
    if ( !empty($booking_no) && !empty($contactInfo) ) {
      $response = EliteParks::updateContact($booking_no, $contactInfo);
      if (!empty($response)) {
        return $response;
      } 
    }
    return null;
  }
  
}
