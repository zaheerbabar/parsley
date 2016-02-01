<?php
namespace Site\Library\Utilities;

class Data
{
    public static function inArray($needle, $haystack, $strict = false) {
        if (!is_array($haystack)) {
            $haystack = [$haystack];
        }

        return \in_array($needle, $haystack, $strict);
    }

    public static function base64URLEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public static function base64URLDecode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

}