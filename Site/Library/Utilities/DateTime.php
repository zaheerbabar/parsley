<?php
namespace Site\Library\Utilities;

class DateTime
{
    public static function getFileDateTimeFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('Ymd_His');
    }

    public static function getDBDateFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('Y-m-d');
    }

    public static function getDBDateTimeFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('Y-m-d H:i:s');
    }

    public static function getFullDateFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('M d, Y');
    }

    public static function getFullDateTimeFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('M d, Y H:i');
    }

    public static function getShortDateFormat($time = 'now') {
        $dateTime = new \DateTime($time);
        return $dateTime->format('d-m-Y');
    }

    public static function getTotalDays($startDate, $endDate) {
	    $start = strtotime($startDate);
	    $end = strtotime($endDate);
	    $totalDays = ceil(abs($end - $start) / 86400) + 1;
	
	    return $totalDays;
	}
}