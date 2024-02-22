<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkAccommodationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("park_accommodations", function (Blueprint $table) {
      $table->id();
      $table->integer('accommodation_id')->unique();
      $table->integer('api_accommodation_code')->nullable();
      $table->text("name")->nullable();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("park_accommodations");
  }
}
