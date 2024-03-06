<?php

namespace Clockwork\HolidayPark\Models;

use Clockwork\Core\Abstracts\GenericModel;
use Clockwork\Accommodation\Models\Accommodation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ParkAccommodationable extends GenericModel
{
  protected $table = "park_accommodationables";
  protected $with = [];
  protected $fillable = ["park_accommodation_id", "park_accommodationable_id", "park_accommodationable_type"];
}
