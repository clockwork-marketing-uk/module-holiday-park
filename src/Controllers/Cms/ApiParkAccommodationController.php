<?php

namespace Clockwork\HolidayPark\Controllers\Cms;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;

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

    $parkAccommodation = $this->parkAccommodationRepository->updateOrCreate($request->model);

    return response()->json([
      "parkAccommodation" => $parkAccommodation,
      "csrf_token" => csrf_token(),
    ]);
  }

  public function update(Request $request, $id)
  {
    $this->store($request);
  }

  public function destroy($accommodatonId)
  {
    $this->parkAccommodationRepository->delete($accommodatonId);
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

  public function findByAccommodationId($accommodatonId) {
    return response()->json([
      "parkAccommodation" => ParkAccommodation::where('accommodation_id', $accommodatonId)->first(),
      "csrf_token" => csrf_token(),
    ]);
  }
}
