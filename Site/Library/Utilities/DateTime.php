<?php
namespace Site\Library\Utilities;

class DateTime
{
    public static function fileDateTimeFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('Ymd_His');
    }

    public static function dbDateFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('Y-m-d');
    }

    public static function dbDateTimeFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('Y-m-d H:i:s');
    }

    public static function fullDateFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('M d, Y');
    }

    public static function fullDateTimeFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('M d, Y H:i');
    }

    public static function shortDateFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('d-m-Y');
    }

    public static function totalDays($startDate, $endDate) {
	    $start = strtotime($startDate);
	    $end = strtotime($endDate);
	    $totalDays = ceil(abs($end - $start) / 86400) + 1;
	
	    return $totalDays;
	}
}