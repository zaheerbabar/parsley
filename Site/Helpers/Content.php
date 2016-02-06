<?php
namespace Site\Helpers;

use Site\Components as Components;

class Content extends Helper
{
    public static function shortDesc($data, $char, $ellipsis = true) {
        $part = trim(substr($data, 0, strpos($data, ' ', $char)), '. ');
        if (!empty($part)) {
            if ($ellipsis) return sprintf('%s...', $part);
            return $part;
        }

        return $data;
    }
    
    public static function shortLenDesc($data, $len = 150, $ellipsis = true) {
        $part = trim(substr($data, 0, $len), '. ');
        if (!empty($part)) {
            if ($ellipsis) return sprintf('%s...', $part);
            return $part;
        }

        return $data;
    }

    public static function capitalizeFirst($string) {
        return ucfirst(strtolower($string));
    }

    public static function capitalizeWord($string) {
        return ucwords(strtolower($string));
    }

    public static function getYesNo($bool) {
	    if ($bool) return 'Yes';
        return 'No';
    }

    public static function replaceSpaceWithDash($string){
	    return strtolower(str_replace(' ', '-', $string));
    }

    public static function viewImage($image, $thumb = false, $attributes = []) {
        $_attr = parent::getAttributes($attributes);
        $link = Components\Path::imageLink($image, $thumb);

        $_output = sprintf('<img src="%s" %s>', $link, $_attr);


        return $_output;
    }
    
}