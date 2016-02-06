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
    
    public static function refresh() {
        header('Refresh:0');
        exit();
    }

    public static function redirectBack() {
        if (empty($_SERVER['HTTP_REFERER'])) {
            if(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == $_SERVER['HTTP_HOST']) {
                self::redirect($_SERVER['HTTP_REFERER']);
            }
        }
        
        self::refresh();
    }

    public static function redirectError($code) {
        \http_response_code($code);
        self::redirect('/error/error.php');
    }
}