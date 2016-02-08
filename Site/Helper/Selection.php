<?php
namespace Site\Helper;

class Selection extends BaseHelper
{
    const ACTIVE_CLASS = 'active';
    
    public static function isIndex($index, $class = null, $attributes = []) {
        if (Page::index() == $index) {
            if (!empty($class)) return $class;
            if (!empty($attributes)) parent::getAttributes($attributes);
            
            return self::ACTIVE_CLASS;
        }
    }
}