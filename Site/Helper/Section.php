<?php
namespace Site\Helper;

use Site\Components as Components;

class Section extends BaseHelper
{
    private static $_sections = [];
    private static $_currentKey = null;
    
    public static function view($key) {
        if (isset(self::$_sections[$key])) {
            return self::$_sections[$key];
        }
        
        return null;
    }
    
    public static function begin($key) {
        self::$_currentKey = $key;
        ob_start();
    }
    
    public static function end() {
        self::$_sections[self::$_currentKey] = ob_get_contents();
        self::$_currentKey = null;
        ob_end_clean();
    }
}