<?php

namespace Clockwork\HolidayPark\Controllers;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\HolidayPark\Services\HolidayParkApiService;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;

class ParkAccommodationController extends CmsController
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

          return view("holidaypark::holiday-park.booking.book", [
            "parkAccommodation" => $parkAccommodation,
            "accommodation" => $accommodation,
            "stay" => $stay
          ]);
        }
      }
    }
    abort(404);
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
