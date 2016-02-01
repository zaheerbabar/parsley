<?php
namespace Site\Helpers;

class Iteration extends Helper
{
    public static function createList($data, $attributes = []) {
        return parent::iterate($data, 'li', $attributes);
    }

    public static function createOptions($data, $attributes = []) {
        return parent::iterateAssociative($data, 'option', $attributes);
    }
}