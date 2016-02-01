<?php
namespace Site\Helpers;

class Message extends Helper
{
    public static function showSingle($messages, $key, $outerTag = 'span', $attributes = []) {
        if (empty($key) == false && empty($messages[$key]['value']) == false) {
            if (empty($outerTag)) {
                return $messages[$key]['value'];
            }

            $_attr = parent::getAttributes($attributes);
            $_output = sprintf('<%s %s>%s</%s>', $outerTag, $_attr, $messages[$key]['value'], $outerTag);

            return $_output;
        }

        return null;
    }

    public static function messageList($data, $attributes = []) {
        return parent::iterate(array_column($data, 'value'), 'li', $attributes);
    }

}