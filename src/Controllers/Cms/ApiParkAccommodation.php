<?php

namespace Clockwork\HolidayPark\Controllers\Cms;

use Clockwork\Core\Abstracts\CmsController;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;
use Illuminate\Http\Request;

class ApiParkAccommodationController extends CmsController
{
  private $parkAccommodationRepository;

  public function __construct(ParkAccommodationRepository $parkAccommodationRepository)
  {
    $this->parkAccommodationRepository = $parkAccommodationRepository;
  }

  public function index(Request $request)
  {
    return response()->json($this->parkAccommodationRepository->all());
  }

  public function show($id)
  {
    return response()->json([
      "parkAccommodation" => $this->parkAccommodationRepository->get($id),
    ]);
  }

  public function edit($id)
  {
    return response()->json([
      "parkAccommodation" => $this->parkAccommodationRepository->get($id),
    ]);
  }

  public function store(Request $request)
  {
    $request->validate($this->parkAccommodationRepository->getValidationRules());
    $id = $this->parkAccommodationRepository->store($request->model);

    return response()->json([
      "id" => $id,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function update(Request $request, $id)
  {
    $request->validate($this->parkAccommodationRepository->getValidationRules());

    $this->parkAccommodationRepository->update($id, $request->model);

    return response()->json([
      "csrf_token" => csrf_token(),
    ]);
  }

  public function destroy($id)
  {
    $this->parkAccommodationRepository->delete($id);
  }

  public function reorder(Request $request)
  {
    foreach ($request->items as $key => $item) {
      $attrs = [
        "sort_order" => $key + 1,
      ];

      $this->parkAccommodationRepository->update($item["id"], $attrs);
    }
  }
}
