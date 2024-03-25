<?php

namespace Clockwork\HolidayPark\Repositories;

use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\Core\Abstracts\CmsGenericRepository;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Models\ParkAccommodationable;
use Clockwork\HolidayPark\Models\ParkAccommodationType;
use Clockwork\HolidayPark\Contracts\ParkAccommodationInterface;

class ParkAccommodationRepository extends CmsGenericRepository implements ParkAccommodationInterface
{
  public function __construct()
  {
    parent::__construct(new ParkAccommodation());
  }

  public function allRelatedAccommodation () {
    $parkAccommodations = $this->modelClass::all();
    $accommodations = collect([]);
    foreach ($parkAccommodations as $parkAccommodation) {
      if (!empty($parkAccommodation->accommodation) && $parkAccommodation->accommodation->count() > 0) {
        $accommodations->push($parkAccommodation->accommodation[0]);
      }
    }
    return $accommodations;
  }

  public function all() {
    return $this->modelClass::all();
  }

  public function updatePivot($id, $category_id, array $attributes)
  {
    $model = $this->modelClass::with("categories")->find($id);
    // parentheses are needed as it throws an error 10/10/23
    $model->categories()->updateExistingPivot($category_id, $attributes);
  }

  public function active()
  {
  }
  public function getByBaseAttribute($attr, $value)
  {
  }
  public function getRuleAttributeNames($prefix = 'model.')
  {
  }

  public function delete($accommodatonId)
  {
    ParkAccommodation::where('accommodation_id', $accommodatonId)->delete();
  }

  public function updateOrCreate(array $attributes)
  {
    $parkAccommodation = ParkAccommodation::find($attributes['id']);
    if (!$parkAccommodation) {
      $parkAccommodation = ParkAccommodation::create();
    }

    $parkAccommodation->update(['park_accommodation_type_id' => $attributes['type']]);

    $parkAccommodationable = ParkAccommodationable::where("park_accommodation_id", $parkAccommodation->id)
      ->where("park_accommodationable_type", $attributes["apiPropertyType"]);

    if (!$parkAccommodationable->exists()) {
      ParkAccommodationable::create([
        "park_accommodationable_id" => $attributes["apiPropertyId"],
        "park_accommodationable_type" => $attributes["apiPropertyType"],
        "park_accommodation_id" => $parkAccommodation->id
      ]);
    } else {
      if (!empty($attributes["apiPropertyId"])) {
        ParkAccommodationable::where("park_accommodation_id", $parkAccommodation->id)
          ->where("park_accommodationable_type", $attributes["apiPropertyType"])
          ->update(["park_accommodationable_id" => $attributes["apiPropertyId"]]);
      } else {
        ParkAccommodationable::where("park_accommodation_id", $parkAccommodation->id)
          ->where("park_accommodationable_type", $attributes["apiPropertyType"])->delete();
      }
    }

    $existingParkAccommodationable = ParkAccommodationable::where("park_accommodation_id", "=", $parkAccommodation->id)->where("park_accommodationable_type", "=", Accommodation::class)->first() ?? null;
    if (!empty($existingParkAccommodationable)) {
      $existingParkAccommodationable->update(["park_accommodationable_id" => $attributes["accommodationId"]]);
    }
    else {
      ParkAccommodationable::create([
        "park_accommodationable_id" => $attributes["accommodationId"],
        "park_accommodationable_type" => Accommodation::class,
        "park_accommodation_id" => $parkAccommodation->id
      ]);
    }

    return $parkAccommodation;
  }

  public function getTypes() {
    return ParkAccommodationType::all();
  }
}
