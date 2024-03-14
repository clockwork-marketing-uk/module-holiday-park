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
        $table->string("booking_no", 20);
        $table->integer("booking_type");
        $table->date("arrival_date");
        $table->integer("no_of_nights");
        $table->integer("no_of_adults");
        $table->integer("no_of_children")->default(0);
        $table->integer("no_of_pets")->default(0);
        $table->string("park_code", 20);
        $table->string("grade_code", 20);

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
