<?php
namespace Site\Components;

class Path
{
    public static function buildPath($segments) {
        return implode(DS, func_get_args($segments));
    }

    public static function imageLink($image, $thumb = false) {
        if (empty($image)) new InvalidArgumentException('Not a valid input.');

        if ($thumb) return THUMB_URL.$image;

        return IMAGE_URL.$image;
    }
    
    public static function link($url, $addToken = false, $query = []) {
        if (empty($url)) new InvalidArgumentException('Not a valid input.');

        $outputFormat = '%s?%s';

        if (empty($query) == false) return sprintf($outputFormat, $url, http_build_query($query));
    }

    public static function redirect($location, $status = 302) {
        header(sprintf('Location: %s', $location), true, $status);
        exit();
    }

    public static function redirectNotFound() {
        self::redirect('/error/404.php');
    }

    public static function redirectForbidden() {
        self::redirect('/error/403.php');
    }

    public static function redirectBadRequest() {
        self::redirect('/error/400.php');
    }
}