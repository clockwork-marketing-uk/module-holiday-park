<?php

namespace Clockwork\HolidayPark\Interfaces;

interface HolidayParkApiInterface
{
    public function getAccommodationData();
    public static function findAvailability($params);
}
