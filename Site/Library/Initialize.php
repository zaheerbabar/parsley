<?php
/**
Initializing required scripts
Note: Consider the require order
**/

if (version_compare(phpversion(), '5.3.0', '<') == true) {
    exit('PHP 5.3+ Required');
}

use Site\Library as Library;

require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Site/Config.php');

require_once realpath(SITE_DIR.'/Library/Loader.php');
Library\Loader::loadAll(SITE_DIR.'/Library/Compatibility/', true);
Library\Loader::registerAutoload();

require_once realpath(SITE_DIR.'/Library/Packages/vendor/autoload.php');

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

if (ROUTE) {
    $route = new Library\Route();
    $route->execute();
}