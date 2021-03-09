<?php


namespace app\src\util;


/**
 * Class Time
 * @package app\src\util
 */
class Time
{
    public static function since(int $time): string
    {
        $time = time() - $time;

        $tokens = array (
            365*24*60*60 => 'year',
            30*24*60*60 => 'month',
            7*24*60*60 => 'week',
            24*60*60 => 'day',
            60*60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        $result = '';
        $counter = 0;
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            if ($counter > 1) break;

            $numberOfUnits = floor($time / $unit);
            $s = $numberOfUnits > 1 ? "s" : "";

            $result .= "$numberOfUnits $text$s ";
            $time -= $numberOfUnits * $unit;
            ++$counter;
        }

        if ($result === "") {
            return "Just now";
        }

        return "{$result}ago";
    }
}