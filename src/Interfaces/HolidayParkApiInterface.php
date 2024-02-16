<?php

namespace Clockwork\HolidayPark\Interfaces;

use Illuminate\Support\Collection;
use Clockwork\Core\Abstracts\RepositoryBaseContract;

interface HolidayParkApiInterface
{
    public function getAccommodationData();
    public function getAvailabilityData();
}
