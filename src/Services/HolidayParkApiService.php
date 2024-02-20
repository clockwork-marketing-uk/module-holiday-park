<?php

namespace Clockwork\HolidayPark\Services;

use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\HolidayPark\Interfaces\HolidayParkApiInterface;

class HolidayParkApiService implements HolidayParkApiInterface
{
    private $api;
    public function __construct() {
        $this->api = 'elite';
    }
    public function getAccommodationData() {
        switch ($this->api) {
            case 'elite':
                $accommodationData = EliteParks::getSetup();
                break;
            default:
                $accommodationData = collect([]);
                break;
        }

        return $accommodationData;
      }
      public function getAvailabilityData() {
        return collect([]);
      }
}



