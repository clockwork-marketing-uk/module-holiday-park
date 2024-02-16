<?php

namespace Clockwork\HolidayPark\Controllers\Cms;

use Clockwork\Core\Abstracts\CmsController;
use Illuminate\Http\Request;
use Clockwork\Accommodation\Contracts\FacilityInterface;

class ApiParkAccommodationController extends CmsController
{
  private $facility;

  public function __construct(FacilityInterface $facility)
  {
    $this->facility = $facility;
  }

  public function index(Request $request)
  {
    return response()->json($this->facility->all());
  }

  public function show($id)
  {
    return response()->json([
      "facility" => $this->facility->get($id),
    ]);
  }

  public function edit($id)
  {
    return response()->json([
      "facility" => $this->facility->get($id),
    ]);
  }

  public function store(Request $request)
  {
    $request->validate($this->facility->getValidationRules());
    $id = $this->facility->store($request->model);

    return response()->json([
      "id" => $id,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function update(Request $request, $id)
  {
    $request->validate($this->facility->getValidationRules());

    $this->facility->update($id, $request->model);

    return response()->json([
      "csrf_token" => csrf_token(),
    ]);
  }

  public function destroy($id)
  {
    $this->facility->delete($id);
  }

  public function reorder(Request $request)
  {
    foreach ($request->items as $key => $item) {
      $attrs = [
        "sort_order" => $key + 1,
      ];

      $this->facility->update($item["id"], $attrs);
    }
  }
}
