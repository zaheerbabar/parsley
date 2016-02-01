<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;

class Page
{
    private static $_title = SITE_TITLE;
    private static $_index;

    public static function setTitle($page) {
        self::$_title = sprintf('%s - %s', $page, SITE_TITLE);
    }
    
    public static function siteTitle() {
        return SITE_TITLE;
    }

    public static function title() {
        return self::$_title;
    }
    
    public static function setIndex($keyword) {
        self::$_index = $keyword;
    }
    
    public static function isIndex($keyword) {
        return (self::$_index == $keyword);
    }
    
    public static function index() {
        return self::$_index;
    }

    public static function includes($file) {
        $file = realpath(sprintf('%s/Includes/%s.php', SITE_DIR, $file));
        return include_once($file);
    }
}