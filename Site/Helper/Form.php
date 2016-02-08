<?php
namespace Site\Helper;

class Form extends BaseHelper
{
    public static function viewPostBackField($attributes = []) {
        $_attr = parent::getAttributes($attributes);
        $_output = sprintf('<input type="hidden" name="_postback" value="1" %s>', $token, $_attr);

        return $_output;
    }
}