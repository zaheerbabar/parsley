<?php
namespace Site\Helper;

class Link extends BaseHelper
{    
    public static function route($route = null, $token = null, $isPostBack = false, $query = null) {
        $url = [];
        
        if (empty($route) == false) {
            $url['_route'] = $route;
        }
        
        if (empty($token) == false) {
            $url['_token'] = $token;
        }
        
        if ($isPostBack) {
            $url['_postback'] = true;
        }
        
        if (empty($query) == false) {
            $url = \array_merge($url, $query);
        }
        
        if (empty($url)) {
            return BASE_URL;
        }
        
        return '?' . htmlentities(http_build_query($url));
    }
    
    public static function image($image = null, $thumb = false) {
        $image = htmlentities(urlencode($image));
        
        if ($thumb) {
            return THUMB_URL . $image;
        }
        
        return IMAGE_URL . $image;
    }
    
    
    public static function upload($file = null) {
        $file = htmlentities(urlencode($file));
        return UPLOAD_URL . urlencode($file);
    }
    
}