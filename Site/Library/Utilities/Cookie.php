<?php
namespace Site\Library\Utilities;

class Cookie
{
    static public function setCookie($key, $value, $expire = '', $path = '/', $domain = '', $secure = false, $httpOnly = true) {
        if (empty($expire)) {
            $expire = strtotime('+1 hour');
        }
        
        setcookie ($key, trim($value), $expire, $path, $domain, $secure, $httpOnly);
    }

    static public function getCookie($key) {
        if (self::isCookieSet($key)) {
            return trim($_COOKIE[$key]);
        }

        return null;
    }

    static public function isCookieSet($key) {
        return isset($_COOKIE[$key]);
    }

    static public function removeCookie($key, $path = '/') {
        if (self::isCookieSet($key)) {
            unset($_COOKIE[$key]);
            setcookie($key, null, strtotime('-1 hour'));
        }
    }
}