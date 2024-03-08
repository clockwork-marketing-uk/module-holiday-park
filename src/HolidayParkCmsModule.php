<?php

namespace Clockwork\HolidayPark;

use Clockwork\Core\CmsModuleConfig;
use Clockwork\Core\Abstracts\CmsModule;
use Clockwork\HolidayPark\Contracts\PriceInterface;
use Clockwork\HolidayPark\Contracts\FacilityInterface;
use Clockwork\HolidayPark\Repositories\PriceRepository;
use Clockwork\HolidayPark\Services\HolidayParkApiService;
use Clockwork\HolidayPark\Repositories\FacilityRepository;
use Clockwork\HolidayPark\Interfaces\HolidayParkApiInterface;
use Clockwork\HolidayPark\Interfaces\ParkAccommodationInterface;
use Clockwork\HolidayPark\Contracts\ParkAccommodationTagInterface;
use Clockwork\HolidayPark\Repositories\ParkAccommodationRepository;
use Clockwork\HolidayPark\Repositories\ParkAccommodationTagRepository;
use Clockwork\HolidayPark\Contracts\ParkAccommodationCategoryInterface;
use Clockwork\HolidayPark\Repositories\ParkAccommodationCategoryRepository;

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
        $this->app->bind(HolidayParkApiInterface::class, HolidayParkApiService::class);
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

        $js = [
          __DIR__ . "/resources/js" => base_path("resources/js"),
        ];
        $this->loadResources(__DIR__);
        $this->publishes($views, "public");
        $this->publishes($css, "public");
        $this->publishes($js, "public");
    }

    public static function getConfig()
    {
        return new CmsModuleConfig(self::$name, self::$friendlyName, self::$description);
    }
}
