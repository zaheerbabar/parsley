<?php 
namespace Site\Library\Utilities;

\ini_set('session.use_only_cookies', 1);
\ini_set('session.cookie_httponly', 1);
\ini_set('session.use_trans_sid', 0);
\ini_set('session.hash_function', 'sha256');
\ini_set('session.hash_bits_per_character', 6);
\ini_set('session.entropy_file', '/dev/urandom');
\ini_set('session.entropy_file', 256);

\ini_set('session.gc_maxlifetime', '65535');
\ini_set("session.cookie_lifetime", strtotime('+24 hours'));

\session_name('sid');
\session_start();

class Session
{
    static public function setSession($key, $value) {
        $_SESSION[$key] = trim($value);
    }

    static public function setSessionValue($key, $valueKey, $value) {
        $_SESSION[$key][$valueKey] = trim($value);
    }
    
    static public function isSessionSet($key) {
        return isset($_SESSION[$key]);
    }

    static public function isSessionValueSet($key, $valueKey) {
        return isset($_SESSION[$key][$valueKey]);
    }

    static public function getSession($key) {
        if (self::isSessionSet($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    static public function getSessionValue($key, $valueKey) {
        if ($session = self::getSession($key)) {
            return isset($session[$valueKey]) ? $session[$valueKey] : null; 
        }

        return null;
    }

    public static function getTempSession($key) {
        $session = null;
        if (($session = self::getSession($key)) != null) {
            unset($_SESSION[$key]);
        }

        return $session;
    }

    public static function getTempValueSession($key, $valueKey) {
        $session = null;
        if (($session = self::getSessionValue($key, $valueKey)) != null) {
            unset($_SESSION[$key][$valueKey]);
        }

        return $session;
    }

    static public function removeSession($key) {
        if (self::isSessionSet($key)) {
            unset($_SESSION[$key]);
        }
    }

    static public function removeSessionValue($key, $valueKey) {
        unset($_SESSION[$key][$valueKey]);
    }
    
}