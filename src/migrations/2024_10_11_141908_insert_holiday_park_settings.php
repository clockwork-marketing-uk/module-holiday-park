<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertHolidayParkSettings extends Migration
{
  private $settings;
  private $setting_groups;

  public function __construct()
  {
    $this->settings = DB::table("settings");
    $this->setting_groups = DB::table("setting_groups");
  }

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $group = DB::table("setting_groups")
      ->where("title", "=", "Holiday Park")
      ->first();

    if (!$group) {
      $groupId = DB::table("setting_groups")->insertGetId([
        "title" => "Holiday Park",
        "description" => "Settings for the holiday park module",
      ]);

      $this->settings->insert([
        "key" => "park_booking_success",
        "value" => "",
        "title" => "Booking Success Page",
        "description" => "The link to the booking success page",
        "type" => "dynamic-link",
        "weight" => "0",
        "group_id" => $groupId,
      ]);

      $this->settings->insert([
        "key" => "park_booking_failed",
        "value" => "",
        "title" => "Booking Failed Page",
        "description" => "The link to the booking failed page",
        "type" => "dynamic-link",
        "weight" => "0",
        "group_id" => $groupId,
      ]);

      $this->settings->insert([
        "key" => "park_confirmation_page",
        "value" => "",
        "title" => "Booking Confirmation Page",
        "description" => "The link to the booking confirmation page",
        "type" => "dynamic-link",
        "weight" => "0",
        "group_id" => $groupId,
      ]);
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    $this->setting_groups->where('title', '=', 'Holiday Park')->delete();
    $this->settings->where("key", "park_booking_success")->delete();
    $this->settings->where("key", "park_booking_failed")->delete();
    $this->settings->where("key", "park_confirmation_page")->delete();
  }
}
