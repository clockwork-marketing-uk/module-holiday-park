<?php

namespace Clockwork\HolidayPark\Models;

use Clockwork\EliteParks\Models\Property;
use Clockwork\Core\Abstracts\GenericModel;
use Clockwork\Accommodation\Models\Accommodation;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ParkBooking extends GenericModel
{
  use HasTimestamps;
  protected $table = "park_bookings";
  protected $with = [];
  protected $fillable = [
    "park_accommodation_id",
    "booking_no",
    "booking_type",
    "arrival_date",
    "no_of_nights",
    "no_of_adults",
    "no_of_children",
    "park_code",
    "grade_code",
    "no_of_pets",
    "created_at",
    "updated_at",
  ];
}
