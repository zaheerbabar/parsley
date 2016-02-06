<?php
namespace Site\Helpers;

class Iteration extends Helper
{
    public static function viewList($data, $attributes = []) {
        return parent::iterate($data, 'li', $attributes);
    }

    public static function viewOptions($data, $attributes = []) {
        return parent::iterateAssociative($data, 'option', $attributes);
    }
    
    public static function implode($array, $glue = ', ') {
        return implode($glue, $array);
    }
}