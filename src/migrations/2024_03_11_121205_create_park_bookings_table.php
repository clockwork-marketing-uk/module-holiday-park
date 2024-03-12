<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Clockwork\HolidayPark\Models\ParkAccommodationType;

class CreateParkBookingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (!Schema::hasTable('park_bookings')) {
      Schema::create("park_bookings", function (Blueprint $table) {
        $table->id();
        $table->integer("park_accommodation_id");
        $table->text("booking_id");
        $table->timestamps();
      });
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("park_bookings");
  }
}
