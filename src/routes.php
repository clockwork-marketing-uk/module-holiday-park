<?php

use Illuminate\Support\Facades\Route;
use Clockwork\Settings\Repositories\SettingRepository;
use Clockwork\HolidayPark\Controllers\ParkAccommodationController;
use Clockwork\HolidayPark\Controllers\Cms\ApiParkAccommodationController;

$holiday_park_prefix = null;

try {
    $holiday_park_prefix = app(SettingRepository::class)->getValueByKey("park_accommodation_route");
} catch (Exception $e) {
    // do nothing (lol)
}

Route::prefix($holiday_park_prefix)->group(function () {
    // Route::get("category/{slug}", [ParkAccommodationCategoryController::class, "category"])->name("park-accommodation.category");
    Route::get("/{slug}", [ParkAccommodationController::class, "page"])->name("park-accommodation.page");
});

Route::prefix("/cms/api/holiday-park/")
  ->middleware(["web", "auth", "moduleAccess"])
  ->name("cms.holiday-park.")
  ->group(function () {
    Route::post("park-accommodation/reorder", [ApiParkAccommodationController::class, "reorder"]);
    Route::get('park-accommodation', [ApiParkAccommodationController::class, 'index']);
    Route::post('park-accommodation', [ApiParkAccommodationController::class, 'store']);
    Route::get('park-accommodation/{id}', [ApiParkAccommodationController::class, 'show']);
    Route::post('park-accommodation/{id}', [ApiParkAccommodationController::class, 'update']);
    Route::patch('park-accommodation/{id}', [ApiParkAccommodationController::class, 'edit']);
    Route::delete('park-accommodation/{id}', [ApiParkAccommodationController::class, 'destroy']);
  });
