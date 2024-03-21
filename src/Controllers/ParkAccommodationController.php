<?php

namespace Clockwork\HolidayPark\Controllers;

use Clockwork\EliteParks\Jobs\GetSetup;
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

  public function dispatchGetSetupJob() {
    GetSetup::dispatchSync();
  }
}
