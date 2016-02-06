<?php
namespace Site\Helpers;

class Message extends Helper
{
    public static function view($messages, $key, $outerTag = 'span', $attributes = []) {
        if (empty($key) == false && empty($messages[$key]['value']) == false) {
            if (empty($outerTag)) {
                return $messages[$key]['value'];
            }
            
            if (empty($attributes)) {
                $attributes = ['class' => $messages[$key]['type']];
            }

            $_attr = parent::getAttributes($attributes);
            $_output = sprintf('<%s %s>%s</%s>', $outerTag, $_attr, $messages[$key]['value'], $outerTag);

            return $_output;
        }

        return null;
    }

    public static function viewList($data, $attributes = []) {
        return parent::iterate(\array_column($data, 'value'), 'li', $attributes);
    }

}