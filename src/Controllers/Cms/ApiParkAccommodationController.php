<?php

namespace Clockwork\HolidayPark\Controllers\Cms;

use Illuminate\Http\Request;
use Clockwork\Core\Abstracts\CmsController;
use Clockwork\Accommodation\Models\Accommodation;
use Clockwork\HolidayPark\Models\ParkAccommodation;
use Clockwork\HolidayPark\Models\ParkAccommodationType;
use Clockwork\HolidayPark\Services\HolidayParkApiService;
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

  public function findByAccommodationId($accommodationId) {
    return response()->json([
      "parkAccommodation" => HolidayParkApiService::getParkAccommodationByAccommodationId($accommodationId),
      "csrf_token" => csrf_token(),
    ]);
  }

  public function getApiProperties() {
    return response()->json([
      "properties" => HolidayParkApiService::getProperties(),
      "csrf_token" => csrf_token(),
    ]);
  }

  public function getTypes() {
    return response()->json([
      "types" => ParkAccommodationType::all(),
      "csrf_token" => csrf_token(),
    ]);
  }

  public function getAvailability(Request $request) {
    $attributes = $request->all();
    $availability = [];
    if (!empty($attributes)) {
      $availability = HolidayParkApiService::findAvailability($attributes);
    }
    return response()->json([
      "availability" => $availability->getData(),
      "csrf_token" => csrf_token(),
    ]);
  }
}
