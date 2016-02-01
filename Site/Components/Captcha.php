<?php
namespace Site\Components;

require_once realpath(SITE_DIR.'/Library/Protection/ReCaptcha/recaptchalib.php');

class Captcha
{
    private static $_errorCode = null;

    public static function getHTML() {
        return recaptcha_get_html(CAPTCHA_PUBLIC_KEY, self::$_errorCode, SSL);
    }

    public static function checkAnswer() {
        $resp = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        
        if ($resp->is_valid == false) {
            self::$_errorCode = $resp->error;
            return $resp->error;
        }

        self::$_errorCode = null;
        return true;
    }
}