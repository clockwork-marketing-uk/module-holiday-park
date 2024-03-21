<?php

use Illuminate\Support\Facades\Route;
use Clockwork\Settings\Repositories\SettingRepository;
use Clockwork\HolidayPark\Controllers\BookingController;
use Clockwork\HolidayPark\Controllers\Api\ApiBookingController;
use Clockwork\HolidayPark\Controllers\ParkAccommodationController;
use Clockwork\HolidayPark\Controllers\Cms\ApiParkAccommodationController;
use Clockwork\HolidayPark\Controllers\ParkAccommodationCategoryController;

$holiday_park_prefix = null;

try {
  $holiday_park_prefix = app(SettingRepository::class)->getValueByKey("accommodation_route");
} catch (Exception $e) {
  // do nothing (lol)
}

Route::prefix($holiday_park_prefix)->middleware(['web'])->group(function () {
  // Route::get("category/{slug}", [ParkAccommodationCategoryController::class, "category"])->name("park-accommodation.category");
  Route::get("{title}/book", [BookingController::class, "book"])->name("park-accommodation.book");
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

    Route::get('/get-setup', [ParkAccommodationController::class, 'dispatchGetSetupJob']);
  });


Route::post('/holiday-park/get-availability', [ApiParkAccommodationController::class, 'findAvailability'])->name('holiday-park.get-availability');

Route::prefix("holiday-park/booking")
  ->middleware(['web'])
  ->name("holiday-park.booking")
  ->group(function () {
    Route::post('/update-contact', [ApiBookingController::class, 'updateContact'])->name('.update-contact');
    Route::post('/update-extras', [ApiBookingController::class, 'updateExtras'])->name('.update-extras');
    Route::post('/get-booking', [ApiBookingController::class, 'getBooking'])->name('.get-booking');
    Route::post('/tag-booking', [ApiBookingController::class, 'tagBooking'])->name('.tag-booking');
    Route::post('/update-booking-availability', [ApiBookingController::class, 'updateBookingAvailability'])->name('.update-booking-availability');
    Route::post('/get-master-booking-extras', [ApiBookingController::class, 'getMasterBookingExtras'])->name('.get-master-booking-extras');

    Route::post('/begin-payment', [BookingController::class, 'beginPayment'])->name('.begin-payment');
    
    Route::post('/3d-secure-receive-response', [BookingController::class, 'threeDSecureReceiveResponse'])->name('.3d-secure-receive-response');

    Route::get('3d-secure-start', [BookingController::class, 'threeDSecureStart'])->name('.3d-secure-start');
    
  });