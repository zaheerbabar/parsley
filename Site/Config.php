<?php
define('DEBUG', true);
define('LOCAL', true);

// Development / Debug
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL|E_STRICT);

    //ini_set('memory_limit', '256M');
    //ignore_user_abort(true);
    //set_time_limit (0);
}
else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

if (LOCAL) {
    define('BASE_URL', 'http://localhost:8080/');
    
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'parsley');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
}
else {
    define('BASE_URL', 'http://parsley.microrage.com/');
    
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'mrageco_db11');
    define('DB_USER', 'mrageco_user11');
    define('DB_PASSWORD', 'pi2KE&UbCvkC');
}

if (defined('ROUTE') == false) define('ROUTE', true);
define('SSL', false);

define('SITE_TITLE', 'Parsley');
define('DEFAULT_LANG', 'en-US');
date_default_timezone_set('Asia/Karachi');

define('LOGIN_URL', BASE_URL.'?_route=user/account/login');
define('UPLOAD_URL', BASE_URL.'uploads/');
define('IMAGE_URL', UPLOAD_URL.'images/');
define('THUMB_URL', IMAGE_URL.'thumbs/');

define('NS_PREFIX', 'Site\\');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', rtrim(dirname(__DIR__), DS));
define('SITE_DIR', rtrim(__DIR__, DS));
define('UPLOAD_DIR', sprintf('%suploads', ROOT_DIR.DS));
define('IMAGE_DIR', sprintf('%simages', UPLOAD_DIR.DS));
define('THUMB_DIR', sprintf('%sthumbs', IMAGE_DIR.DS));

define('PAGE_SIZE', 6);
define('IMAGE_WIDTH', 600);
define('IMAGE_HEIGHT', 600);
define('THUMB_WIDTH', 100);
define('THUMB_HEIGHT', 100);

define('SMTP_HOST', '');
define('SMTP_USER', '');
define('SMTP_AUTH', true);
define('SMTP_PASSWORD', '');
define('SMTP_SECURE', 'tls');
define('MAIL_FROM', 'no-reply@example.com');
define('MAIL_FROM_NAME', 'Example - No Reply');

define('CAPTCHA_PUBLIC_KEY', '');
define('CAPTCHA_PRIVATE_KEY', '');

ini_set('log_errors', 1);
ini_set('error_log', SITE_DIR.'/php_errors.log');

// Session
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_trans_sid', 0);
ini_set('session.hash_function', 'sha256');
ini_set('session.hash_bits_per_character', 6);
ini_set('session.entropy_file', '/dev/urandom');
ini_set('session.entropy_file', 256);

ini_set('session.gc_maxlifetime', '65535');
ini_set("session.cookie_lifetime", strtotime('+24 hours'));

session_name('sid');
session_start();
