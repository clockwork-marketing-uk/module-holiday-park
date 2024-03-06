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
  protected $with = ['accommodation', 'accommodation', 'property'];
  protected $fillable = ["text"];

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

}
