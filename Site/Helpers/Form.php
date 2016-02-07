<?php
namespace Site\Helpers;

class Form extends Helper
{
    public static function viewPostBackField($attributes = []) {
        $_attr = parent::getAttributes($attributes);
        $_output = sprintf('<input type="hidden" name="_postback" value="1" %s>', $token, $_attr);

        return $_output;
    }
}