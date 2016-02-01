<?php
namespace Site\Library\Cryptography;

use Site\Library\Utilities as Utilities;

class Random
{
    public static function genString($len = 12) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $len);
    }

    public static function genToken() {
        return Utilities\Data::base64UrlEncode(md5(microtime()));
    }
}