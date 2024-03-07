<?php

namespace Clockwork\HolidayPark\Models;

use Clockwork\EliteParks\Models\Property;
use Clockwork\Core\Abstracts\GenericModel;
use Clockwork\Accommodation\Models\Accommodation;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ParkAccommodation extends GenericModel
{
  protected $table = "park_accommodations";
  protected $with = ['accommodation', 'accommodation', 'property', 'type'];
  protected $fillable = ["text", "park_accommodation_type_id"];

  public function accommodationable(): MorphTo
  {
    return $this->morphTo();
  }

  public function accommodation(): MorphToMany
  {
    return $this->morphedByMany(Accommodation::class, 'park_accommodationable');
  }

  public function property(): MorphToMany
  {
    return $this->morphedByMany(Property::class, 'park_accommodationable');
  }

  public function type() {
    return $this->belongsTo(ParkAccommodationType::class, 'park_accommodation_type_id', 'id');
  }
}
