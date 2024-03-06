<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Clockwork\HolidayPark\Models\ParkAccommodationType;

class CreateParkAccommodationTypesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (!Schema::hasTable('park_accommodation_types')) {
      Schema::create("park_accommodation_types", function (Blueprint $table) {
        $table->id();
        $table->text("name")->nullable();
        $table->integer("booking_type");
        $table->timestamps();
      });

      ParkAccommodationType::create(['name' => 'Accommodation', 'booking_type' => 1]);
      ParkAccommodationType::create(['name' => 'Camping', 'booking_type' => 0]);
    }

    if (Schema::hasTable('park_accommodations')) {
      Schema::table('park_accommodations', function (Blueprint $table) {
        $table->integer('park_accommodation_type_id')->nullable();
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
    Schema::dropIfExists("park_accommodation_types");

    if (Schema::hasColumn('park_accommodations', 'park_accommodation_type_id')) {
      Schema::table('park_accommodations', function (Blueprint $table) {
        $table->dropColumn('park_accommodation_type_id');
      });
    }
  }
}
