<?php

namespace app\helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function dateForHumans(int $timestamp): string
    {
        $carbon = Carbon::createFromTimestamp($timestamp);

        return $carbon->diffForHumans();
    }
}
