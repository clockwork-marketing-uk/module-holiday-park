<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkAccommodationablesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (!Schema::hasTable('park_accommodationables')) {
      Schema::create("park_accommodationables", function (Blueprint $table) {
        $table->integer('park_accommodation_id');
        $table->integer('park_accommodationable_id');
        $table->string('park_accommodationable_type');
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
    Schema::dropIfExists("park_accommodationables");
  }
}
