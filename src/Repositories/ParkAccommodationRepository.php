<?php

namespace Clockwork\HolidayPark\Repositories;

use Clockwork\Core\Abstracts\CmsBaseRepository;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Interfaces\ParkAccommodationInterface;

class ParkAccommodationRepository extends CmsBaseRepository implements ParkAccommodationInterface
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
}
