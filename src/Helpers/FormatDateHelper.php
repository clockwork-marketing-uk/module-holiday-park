<?php

namespace Clockwork\HolidayPark\Helpers;

use Illuminate\Support\Carbon;
use Clockwork\EliteParks\Facades\EliteParks;

class FormatDateHelper
{
  public static function formatDate(string $date, string $inputFormat, string $outputFormat): string
  {
    return Carbon::createFromFormat($inputFormat, $date)->format($outputFormat);
  }
}
