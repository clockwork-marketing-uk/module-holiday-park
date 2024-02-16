<?php

namespace Clockwork\HolidayPark\Controllers;

use Clockwork\Core\Abstracts\CmsController;
use Clockwork\Accommodation\Repositories\AccommodationRepository;
use Illuminate\Http\Request;

class ParkAccommodationController extends CmsController
{
  private $accommodation;

  public function __construct(AccommodationRepository $accommodation)
  {
    $this->accommodation = $accommodation;
    $this->module = "accommodation";
  }

  public function accommodation(Request $request)
  {
    $request_uri = strtok($request->getRequestUri(), "?");

    $url_slug = preg_split("/\//", $request_uri);

    $accommodation = $this->accommodation->getByBaseAttribute("url_slug", $url_slug[2]);

    if (!$accommodation) {
      abort(404);
    }
    return view($this->getViewName("accommodation.accommodation"), ["accommodation" => $accommodation]);
  }
}
