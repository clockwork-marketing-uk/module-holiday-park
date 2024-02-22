<?php

namespace Clockwork\HolidayPark\Controllers;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;

class ParkAccommodationController extends CmsController
{
  private $parkAccommodationRepository;

  public function __construct(ParkAccommodationRepository $parkAccommodationRepository)
  {
    $this->parkAccommodationRepository = $parkAccommodationRepository;
    $this->module = "holidaypark";
  }

  public function accommodation(Request $request)
  {
    $request_uri = strtok($request->getRequestUri(), "?");

    $url_slug = preg_split("/\//", $request_uri);

    $parkAccommodation = $this->parkAccommodationRepository->getByBaseAttribute("url_slug", $url_slug[2]);

    // dd($parkAccommodation);

    if (!$parkAccommodation) {
      abort(404);
    }
    return view($this->getViewName("holiday-park.page"), ["parkAccommodation" => $parkAccommodation]);
  }
}
