<?php

use Illuminate\Support\Facades\Route;
use Clockwork\Settings\Repositories\SettingRepository;
use Clockwork\HolidayPark\Controllers\ParkAccommodationController;
use Clockwork\HolidayPark\Controllers\Cms\ApiParkAccommodationController;
use Clockwork\HolidayPark\Controllers\ParkAccommodationCategoryController;

$holiday_park_prefix = null;

try {
  $holiday_park_prefix = app(SettingRepository::class)->getValueByKey("accommodation_route");
} catch (Exception $e) {
  // do nothing (lol)
}

Route::prefix($holiday_park_prefix)->group(function () {
  // Route::get("category/{slug}", [ParkAccommodationCategoryController::class, "category"])->name("park-accommodation.category");
  Route::get("{title}/book", [ParkAccommodationController::class, "book"])->name("park-accommodation.book");
});

Route::prefix("/cms/api/holiday-park/park-accommodation")
  ->middleware(["web", "auth", "moduleAccess"])
  ->name("cms.holiday-park.")
  ->group(function () {

    Route::post("/reorder", [ApiParkAccommodationController::class, "reorder"]);
    Route::get('/model', [ApiParkAccommodationController::class, 'index']);
    Route::post('/model', [ApiParkAccommodationController::class, 'store']);
    Route::get('/model/{id}', [ApiParkAccommodationController::class, 'show']);
    Route::post('/model/{id}', [ApiParkAccommodationController::class, 'update']);
    Route::patch('/model/{id}', [ApiParkAccommodationController::class, 'edit']);
    Route::delete('/model/{accommodatonId}', [ApiParkAccommodationController::class, 'destroy']);

    Route::get('/findByAccommodationId/{accommodatonId}', [ApiParkAccommodationController::class, 'findByAccommodationId']);

    Route::get('/api-properties', [ApiParkAccommodationController::class, 'getApiProperties']);

    Route::get('/types', [ApiParkAccommodationController::class, 'getTypes']);    
  });


  Route::post('/holiday-park/get-availability', [ApiParkAccommodationController::class, 'findAvailability'])->name('holiday-park.get-availability');
