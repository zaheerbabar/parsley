<?php
namespace Site\Helpers;

use Site\Components as Components;

class Section extends Helper
{
    private static $_sections = [];
    
    public static function view($key) {
        if (isset(self::$_sections[$key])) {
            return self::$_sections[$key];
        }
        
        return null;
    }
    
    public static function add($key, $markup) {
        self::$_sections[$key] = $markup;
    }
}