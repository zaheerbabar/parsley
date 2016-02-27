<?php
namespace Site\Helper;

use Site\Components as Components;

class Protection extends BaseHelper
{
    public static function viewPrivateToken() {
        $token = Components\Token::getPrivateToken();

        return $token;
    }

    public static function viewPublicTokenField($alreadySet = false, $attributes = []) {
        $token = Components\Token::setPublicToken($alreadySet);

        $_attr = parent::getAttributes($attributes);
        $_output = sprintf('<input type="hidden" name="_token" value="%s" %s>', $token, $_attr);

        return $_output;
    }

    public static function viewCaptcha() {
        return Components\Captcha::getHTML();
    }
}