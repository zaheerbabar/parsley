<?php
namespace Site\Components;

use Site\Components as Components;
use Site\Library\Utilities as Utilities;
use Site\Library\Cryptography as Cryptography;

class Token
{
    const _KEY = '_token';

    public static function setPublicToken($alreadySet = false) {
        if ($alreadySet == false) {
            $token = Cryptography\Random::genToken();
            Utilities\Cookie::setCookie(self::_KEY, $token, strtotime('+5 min'));
            
            return $token;
        }
        
        return self::getPublicToken();
    }
    
    public static function getPublicToken() {
        if (($cookieToken = Utilities\Cookie::getCookie(self::_KEY)) != null) {
            return $cookieToken;
        }

        return false;
    }

    public static function validatePublicToken($method = 'POST') {
        if (empty($_POST[self::_KEY])) return false;

        $reqToken = $_POST[self::_KEY];
        
        if ($cookieToken = self::getPublicToken()) {
            return ($reqToken === $cookieToken);
        }

        return false;
    }
    
    public static function removePublicToken() {
        Utilities\Cookie::setCookie(self::_KEY);
    }

    public static function getPrivateToken() {
        if ($token = Components\Auth::getAuthUserData('token')) {
            return $token;
        }

        return false;
    }

    public static function validatePrivateToken() {
        if (empty($_GET[self::_KEY]) && empty($_POST[self::_KEY])) return false;
        
        $reqToken = empty($_GET[self::_KEY]) ? $_POST[self::_KEY] : $_GET[self::_KEY];
        
        if ($userToken = self::getPrivateToken()) {
            return ($reqToken === $userToken);
        }

        return false;
    }
}