<?php

use Clockwork\Settings\Repositories\SettingRepository;

$holiday_park_prefix = null;

try {
    $holiday_park_prefix = app(SettingRepository::class)->getValueByKey("accommodation_route");
} catch (Exception $e) {
    // do nothing
}

Route::prefix($holiday_park_prefix)->group(function () {
    Route::get("category/{slug}", [ParkAccommodationCategoryController::class, "category"])->name("accommodation.category");
    Route::get("/{slug}", [ParkAccommodationController::class, "accommodation"])->name("accommodation.accommodation");
});

Route::prefix("/cms/api/park-accommodation/")
  ->middleware(["web", "auth", "moduleAccess"])
  ->name("cms.park-accommodation.")
  ->group(function () {
    Route::post("park-accommodation/reorder", [ApiParkAccommodationController::class, "reorder"]);
    Route::get('model', [ApiParkAccommodationController::class, 'index']);
    Route::post('model', [ApiParkAccommodationController::class, 'store']);
    Route::get('model/{id}', [ApiParkAccommodationController::class, 'show']);
    Route::post('model/{id}', [ApiParkAccommodationController::class, 'update']);
    Route::patch('model/{id}', [ApiParkAccommodationController::class, 'edit']);
    Route::delete('model/{id}', [ApiParkAccommodationController::class, 'destroy']);
  });
