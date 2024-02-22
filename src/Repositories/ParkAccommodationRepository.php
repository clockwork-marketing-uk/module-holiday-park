<?php

namespace Clockwork\HolidayPark\Repositories;

use Clockwork\Core\Abstracts\CmsGenericRepository;
use Clockwork\HolidayPark\Models\ParkAccommodation;
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

  public function active(){}
  public function getByBaseAttribute($attr, $value){}
  public function getRuleAttributeNames($prefix = 'model.'){}

  public function delete($accommodatonId)
  {
    ParkAccommodation::where('accommodation_id', $accommodatonId)->delete();
  }

  public function updateOrCreate(array $attributes) {
    if (!empty($attributes["accommodation_id"])) {
      return $this->modelClass->updateOrCreate(["accommodation_id" => $attributes["accommodation_id"]], $attributes);
    }
    return null;
  }
}
