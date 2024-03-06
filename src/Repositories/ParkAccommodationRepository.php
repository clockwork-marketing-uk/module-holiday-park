<?php

namespace Clockwork\HolidayPark\Repositories;

use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\Core\Abstracts\CmsGenericRepository;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Models\ParkAccommodationable;
use Clockwork\HolidayPark\Contracts\ParkAccommodationInterface;

class ParkAccommodationRepository extends CmsGenericRepository implements ParkAccommodationInterface
{
  public function __construct()
  {
    parent::__construct(new ParkAccommodation());
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
    $parkAccommodation = ParkAccommodation::updateOrCreate(["id" => $attributes["id"]], []);

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

    // create / update accommodation relationship
    ParkAccommodationable::updateOrCreate(
      ["park_accommodation_id" => $parkAccommodation->id, "park_accommodationable_type" => Accommodation::class],
      ["park_accommodationable_id" => $attributes["accommodationId"]]
    );

    return $parkAccommodation;
  }
}
