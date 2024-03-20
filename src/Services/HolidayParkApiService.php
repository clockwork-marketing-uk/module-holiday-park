<?php

namespace Clockwork\HolidayPark\Services;

use Clockwork\EliteParks\Models\Property;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\HolidayPark\Models\ParkBooking;
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
      $bookingNo = $booking->getData()?->data?->{'@attributes'}?->booking_no ?? null;
      if (!empty($bookingNo)) {
        $booking = EliteParks::getBooking($bookingNo)->getData();
        if (!empty($booking)) {
          return $booking?->data?->{'@attributes'};
        }
      }
    }
    return null;
  }

  public static function getBooking($booking)
  {
    $bookingResponse = EliteParks::getBooking($booking)->getData();
    if ($bookingResponse?->message == "ok") {
      $extras = self::getExtrasFromResponse($bookingResponse?->data?->Extra ?? null);
      // dd($bookingResponse);
      return [
        "booking" => $bookingResponse?->data?->{'@attributes'},
        "extras" => $extras,
      ];
    }
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

  private static function getExtrasFromResponse($extras = null): array
  {

    if (!empty($extras)) {
      if (is_array($extras)) {
        $formattedExtras = [];
        foreach ($extras as $extra) {
          if (!empty($extra) && !empty($extra?->{'@attributes'})) {
            $formattedExtras[] = (array) $extra?->{'@attributes'};
          }
        }
        return $formattedExtras;
      } else {
        return [$extras?->{'@attributes'}];
      }
    }
    return [];
  }

  public static function updateExtras($booking_no, $extras): array | null
  {
    if (!empty($booking_no) && !empty($extras)) {
      $response = EliteParks::updateExtras($booking_no, $extras);
      $extras = $response?->getData()?->data?->Extra ?? null;
      return self::getExtrasFromResponse($extras);
    }
    return null;
  }

  public static function updateContact($booking_no, $contactInfo)
  {
    if (!empty($booking_no) && !empty($contactInfo)) {
      $response = EliteParks::updateContact($booking_no, $contactInfo);
      if (!empty($response)) {
        return $response;
      }
    }
    return null;
  }

  public static function getParkBooking($booking_no)
  {
    return ParkBooking::where('booking_no', $booking_no)->first();
  }

  public static function updateBookingAvailability($parkBooking)
  {
    if (!empty($parkBooking)) {
      $parkBooking = (array) $parkBooking->getAttributes();
      $response = EliteParks::updateBookingAvailability($parkBooking);
      if (!empty($response)) {
        return $response;
      }
    }
    return null;
  }

  public static function getMasterBookingExtras()
  {
    return MasterBookingExtra::all();
  }

  public static function tagBooking($bookingNo)
  {
    $bookingResponse = EliteParks::tagBooking($bookingNo)->getData();
    if ($bookingResponse?->message == "ok") {
      return $bookingResponse;
    }
    else {
      return false;
    }
  }

  public static function bookingSuccess(string $bookingNo, string $price) {
    $makePayment = self::makePayment($bookingNo, $price);
    $confirmBooking = self::confirmBooking($bookingNo);
  }

  public static function bookingFailed(string $bookingNo) {
    $untagBooking = self::untagBooking($bookingNo);
  }

  public static function makePayment(string $bookingNo, string $price) {
    if (!empty($bookingNo) && !empty($price)) {
      $response = EliteParks::makePayment($bookingNo, $price);
      if (!empty($response)) {
        return $response;
      }
    }
    return null;
  }

  public static function confirmBooking(string $bookingNo) {
    if (!empty($bookingNo)) {
      $response = EliteParks::confirmBooking($bookingNo);
      if (!empty($response)) {
        return $response;
      }
    }
    return null;
  }

  public static function untagBooking(string $bookingNo) {
    if (!empty($bookingNo)) {
      $response = EliteParks::untagBooking($bookingNo);
      if (!empty($response)) {
        return $response;
      }
    }
    return null;
  }
}
