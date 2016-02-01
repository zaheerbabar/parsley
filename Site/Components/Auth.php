<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;
use Site\Library\Cryptography as Cryptography;

class Auth
{
    const _KEY = '8af23a89b76962714d84141083c86d484919880457515e46e802a0e89a9166de';
    const _IV = '75ddb2aa32979586e061ab5e88573f78';

    const _AUTH = '_auth';

    public static function genPassHash($pass, $cost = 12) {
        $options = array (
            'cost' => $cost,
        );

        return \password_hash($pass, PASSWORD_BCRYPT, $options);
    }
    
    public static function validatePassHash($pass, $hash) {
        return \password_verify($pass, $hash);
    }
    
    public static function setAuth($user, $persist = false) {
        $crypt = new Cryptography\Crypt(self::_KEY, self::_IV);
        $user->token = Cryptography\Random::genToken();
        
        $expire = \strtotime('+6 hours');
        if ($persist) {
            $expire = \strtotime('+24 hours');
        }

        \session_regenerate_id();
        Utilities\Session::setSession(self::_AUTH, serialize($user));

        Utilities\Cookie::setCookie(self::_AUTH, $crypt->encrypt($user->id), $expire);
    }

    public static function unAuth() {
        Utilities\Session::removeSession(self::_AUTH);
        \session_regenerate_id();

        Utilities\Cookie::removeCookie(self::_AUTH);
        Utilities\Cookie::removeCookie(session_name());

        return true;
    }

    public static function isAuth($roles = null) {
        if (Utilities\Session::isSessionSet(self::_AUTH) && Utilities\Cookie::isCookieSet(self::_AUTH)) {

            $crypt = new Cryptography\Crypt(self::_KEY, self::_IV);

            $user = \unserialize(Utilities\Session::getSession(self::_AUTH));
            
            if ($user->id == self::getAuthCookie()) {
                if (empty($roles)) return true;

                $roles = (is_array($roles)) ? $roles : [$roles];

                foreach ($roles as $role) {    
                    if (Utilities\Data::inArray($role, $user->roles) == false)
                        return false;
                }
                
                return true;
            }
        }

        return false;
    }

    public static function redirectAuth($roles = null, $location = null) {
        if (self::isAuth($roles) == false) return false;

        if (empty($location)) Path::redirect(BASE_URL);
        Path::redirect($location);
    }

    public static function redirectUnAuth($roles = null, $location = null) {
        if (self::isAuth($roles)) return false;

        if (empty($location)) Path::redirect(LOGIN_URL);
        Path::redirect($location);
    }
    
    public static function getAuthUserData($value = null) {
        if (self::isAuth() == false) return false;

        $user = self::getAuthSession();

        if (empty($value) == false) {
            if(isset($user->{$value})) return $user->{$value};
        }

        return $user;
    }

    private static function getAuthSession() {
        return \unserialize(Utilities\Session::getSession(self::_AUTH));
    }

    private static function getAuthCookie() {
        $crypt = new Cryptography\Crypt(self::_KEY, self::_IV);
        return $crypt->decrypt(Utilities\Cookie::getCookie(self::_AUTH));
    }
}