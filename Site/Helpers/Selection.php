<?php
namespace Site\Helpers;

use Site\Components as Components;

class Selection extends Helper
{
    const ACTIVE_CLASS = 'active';
    
    public static function isIndex($index, $class = null, $attributes = []) {
        if (Components\Page::index() == $index) {
            if (!empty($class)) return $class;
            if (!empty($attributes)) parent::getAttributes($attributes);
            
            return self::ACTIVE_CLASS;
        }
    }
}