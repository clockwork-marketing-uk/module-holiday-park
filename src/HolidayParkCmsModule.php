<?php

namespace Clockwork\HolidayPark;

use Clockwork\Core\CmsModuleConfig;
use Clockwork\Core\Abstracts\CmsModule;
use Clockwork\HolidayPark\Interfaces\ParkAccommodationInterface;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;

class HolidayParkCmsModule extends CmsModule
{
    private static $name = "holidaypark";
    private static $friendlyName = "Holiday Park Module";
    private static $description = "Used to manage your holiday park";

    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(ParkAccommodationInterface::class, ParkAccommodationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $views = [
          __DIR__ . "/resources/views" => base_path("resources/views"),
        ];

        $css = [
          __DIR__ . "/resources/css" => base_path("resources/css"),
        ];
        $this->loadResources(__DIR__);
        $this->publishes($views, "bespoke");
        $this->publishes($css, "public");
    }

    public static function getConfig()
    {
        return new CmsModuleConfig(self::$name, self::$friendlyName, self::$description);
    }
}
