<?php

namespace Clockwork\HolidayPark\Services;

use Clockwork\EliteParks\Models\Property;
use Clockwork\EliteParks\Facades\EliteParks;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Models\ParkAccommodationable;
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

      public static function getProperties() {
        return Property::all();
      }

      public static function getParkAccommodationByAccommodationId($accommodationId) {
        $parkAccommodationable = ParkAccommodationable::where('park_accommodationable_id', $accommodationId)
        ->where('park_accommodationable_type', Accommodation::class)->first();

        $parkAccommodation = null;
        if (!empty($parkAccommodationable)) {
          $parkAccommodation = ParkAccommodation::where('id', '=', $parkAccommodationable->park_accommodation_id)->first();
        }

        return $parkAccommodation;
      }
}



