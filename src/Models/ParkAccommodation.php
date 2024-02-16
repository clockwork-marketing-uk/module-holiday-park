<?php

namespace Clockwork\HolidayPark\Models;

use Illuminate\Support\Str;
use Clockwork\Core\Models\Base;
use Clockwork\Core\Traits\Sectionable;
use Clockwork\Core\Abstracts\BaseModel;

class ParkAccommodation extends BaseModel
{
  use Sectionable;

  protected $table = "park_accommodations";
  protected $with = ["base", "images"];

  protected $fillableRelations = [
    "images" => [
      "type" => "morphMany",
      "ref" => "park_accommodation_image",
    ],
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "title",
    "text",
    "page_enabled",
    "sections",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  public function images()
  {
    return $this->getSectionImages("accommodation_image");
  }

  public function base()
  {
    return $this->morphOne(Base::class, "baseable");
  }

  /**
   * Scope a query to return based on sort_order column.
   *
   * @param mixed $query
   */
  public function scopeOrdered($query)
  {
    return $query->orderBy("sort_order", "asc");
  }

  public function getFullUrl($base_model)
  {
    return route("accommodation.accommodation", ["slug" => $base_model->url_slug], false);
  }
}
