<?php
namespace app\helpers;

class TextHelper
{
    public static function plural(int $count, string $zero, string $one, string $few, string $many): string
    {
        if ($count === 0) {
            return $zero;
        }

        $mod10 = $count % 10;
        $mod100 = $count % 100;

        if ($mod10 == 1 && $mod100 != 11) {
            $text = $one;
        } elseif ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) {
            $text = $few;
        } else {
            $text = $many;
        }

        return str_replace('#', $count, $text);
    }
}
