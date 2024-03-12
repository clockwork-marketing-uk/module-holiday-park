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
}
