<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;

class Page
{
    private static $_pageTitle = SITE_TITLE;

    public static function setPageTitle($page = null) {
        if (empty($page)) {
            self::$_pageTitle = SITE_TITLE;
        }

        self::$_pageTitle = sprintf('%s - %s', $page, SITE_TITLE);
    }

    public static function getPageTitle($page = null) {
        return self::$_pageTitle;
    }

    public static function includes($file) {
        $file = realpath(sprintf('%s/Includes/%s.php', SITE_DIR, $file));
        return include_once($file);
    }
}