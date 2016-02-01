<?php
define('DEBUG', true);

define('SITE_TITLE', 'Parsley');
define('BASE_URL', 'http://localhost:8080');
define('LOGIN_URL', BASE_URL.'user/login.php');
define('UPLOAD_URL', BASE_URL.'uploads/');
define('IMAGE_URL', UPLOAD_URL.'images/');
define('THUMB_URL', IMAGE_URL.'thumbs/');
define('SSL', false);

define('DEFAULT_LANG', 'en-US');
date_default_timezone_set('Asia/Karachi');

define('NAMESPACE_PREFIX', 'Site\\');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', rtrim(dirname(__DIR__), DS));
define('SITE_DIR', rtrim(__DIR__, DS));
define('UPLOAD_DIR', sprintf('%suploads', ROOT_DIR.DS));
define('IMAGE_DIR', sprintf('%simages', UPLOAD_DIR.DS));
define('THUMB_DIR', sprintf('%sthumbs', IMAGE_DIR.DS));

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


// Development / Debug
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL|E_STRICT);

    //ini_set('memory_limit', '256M');
    //ignore_user_abort(true);
    //set_time_limit (0);

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'parsley');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
}
else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'parsley');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
}

ini_set('log_errors', 1);
ini_set('error_log', SITE_DIR.'/php_errors.log');
