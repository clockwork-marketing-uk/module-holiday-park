<?php

namespace Clockwork\HolidayPark\Controllers;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
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
    $accommodationId = $request->query('id') ?? null;
    if (!empty($accommodationId)) {
      $parkAccommodation = HolidayParkApiService::getParkAccommodationByAccommodationId($accommodationId);
      $accommodation = Accommodation::find($accommodationId);
      
      if (!empty($parkAccommodation) && !empty($accommodation)) {
        return view($this->getViewName("holiday-park.book"), [
          "parkAccommodation" => $parkAccommodation,
          "accommodation" => $accommodation
        ]);
      }
    }
    abort(404);
  }
}
