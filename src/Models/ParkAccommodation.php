<?php

namespace Clockwork\HolidayPark\Models;

use Clockwork\Core\Abstracts\GenericModel;

class ParkAccommodation extends GenericModel
{
  protected $table = "park_accommodations";
  protected $with = [];
  protected $fillable = ["accommodation_id", "api_accommodation_code"];

}
