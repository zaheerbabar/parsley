<?php
namespace Site\Helpers;

use Site\Components as Components;

class Protection extends Helper
{
    public static function showPrivateToken() {
        $token = Components\Token::getPrivateToken();

        return $token;
    }

    public static function showPublicTokenField($attributes = []) {
        $token = Components\Token::setPublicToken();

        $_attr = parent::getAttributes($attributes);
        $_output = sprintf('<input type="hidden" name="_token" value="%s" %s />', $token, $_attr);

        return $_output;
    }

    public static function showCaptcha() {
        return Components\Captcha::getHTML();
    }
}