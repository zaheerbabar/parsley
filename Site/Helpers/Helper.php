<?php
namespace Site\Helpers;

class Helper
{
    public static $viewData;
    
    protected static function getAttributes(array $attributes) {
        if (empty($attributes)) return null;

        $_output = '';
        foreach($attributes as $key => $value) {
            $_output .= sprintf('%s="%s" ', $key, $value);
        }
        
        return rtrim($_output);
    }

    protected static function iterate(array $data, $outerTag = 'li', array $attributes = []) {
        $_output = '';
        $_attributes = self::getAttributes($attributes);
        
        foreach ($data as $row) {
            $_output .= sprintf('<%s %s>%s</%s>', $outerTag, $_attributes, $row, $outerTag);
        }

        return $_output;
    }

    protected static function iterateAssociative(array $data, $outerTag = 'option', array $attributes = []) {
        $_output = '';
        $_attributes = self::getAttributes($attributes);
        
        foreach ($data as $key => $value) {
            $_output .= sprintf('<%s %s value="%s">%s</%s>', $outerTag, $_attributes, $key, $value, $outerTag);
        }

        return $_output;
    }
}