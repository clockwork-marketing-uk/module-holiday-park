<?php

namespace Clockwork\HolidayPark\Models;

use Clockwork\Core\Abstracts\GenericModel;

class ParkAccommodationType extends GenericModel
{
  protected $table = "park_accommodation_types";

  protected $fillable = ["name", "booking_type"];

}
