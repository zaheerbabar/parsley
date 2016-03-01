<?php
namespace Site\Helper;

class Form extends BaseHelper
{
    public static function viewPostBackField($attributes = []) {
        $_attr = parent::getAttributes($attributes);
        $_output = sprintf('<input type="hidden" name="_postback" value="1" %s>', $token, $_attr);

        return $_output;
    }
    
    public static function viewCheckbox($data, $attributes = []) {
        $_attr = parent::getAttributes($attributes);
        
        if (self::isTrue($data)) {
            $_output = sprintf('<input type="checkbox" checked %s>', $_attr);
        }
        else {
            $_output = sprintf('<input type="checkbox" %s>', $_attr);
        }

        return $_output;
    }
}