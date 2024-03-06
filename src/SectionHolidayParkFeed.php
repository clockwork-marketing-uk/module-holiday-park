<?php

namespace Clockwork\HolidayPark;

use Clockwork\Core\Abstracts\PageSection;

class SectionHolidayParkFeed extends PageSection
{
  public static function getConfig()
  {
    return [
      "fields" => [
        "title" => "Holiday Park Feed",
      ],
      "sectionName" => "Holiday Park Feed",
      "view" => "section-holiday-park-feed",
      "icon" => "bed-front",
      "type" => "feed",
    ];
  }

  /**
   * Bootstrap services.
   */
  public function boot()
  {
    $sections = [
      __DIR__ . "/resources/views/sections" => base_path("resources/views/sections"),
    ];
    $this->publishes($sections, "public");
  }
}
