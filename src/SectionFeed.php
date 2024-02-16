<?php

namespace Clockwork\HolidayPark;

use Clockwork\Core\Abstracts\PageSection;

class SectionFeed extends PageSection
{
  public static function getConfig()
  {
    return [
      "fields" => [
        "title" => "Feed",
      ],
      "sectionName" => "Feed",
      "view" => "section-feed",
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
    // $this->publishes($sections, "public");
  }
}
