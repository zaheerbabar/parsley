<?php
namespace Site\Components;

class Path
{
    public static function buildPath($segments) {
        return implode(DS, func_get_args($segments));
    }

    public static function redirect($url = '/', $query = null, $status = 302) {
        if (empty($query) == false) {
            $url .= '?' . http_build_query($query);
        }
        
        header(sprintf('Location: %s', $url), true, $status);
        exit();
    }
    
    public static function redirectRoute($route = null, $query = null, $status = 302) {
        $url = [];
        
        if (empty($route) == false) {
            $url['_route'] = $route;
        }
        
        if (empty($query) == false) {
            $url = \array_merge($url, $query);
        }
        
        self::redirect('/', $url, $status);
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
}