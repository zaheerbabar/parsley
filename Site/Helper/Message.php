<?php
namespace Site\Helper;

class Message extends BaseHelper
{
    public static function view($message, $outerTag = 'span', $attributes = []) {
        if (empty($outerTag)) {
            return $message['value'];
        }
        
        if (empty($attributes)) {
            $attributes = ['class' => $message['type']];
        }

        $_attr = parent::getAttributes($attributes);
        $_output = sprintf('<%s %s>%s</%s>', $outerTag, $_attr, $message['value'], $outerTag);

        return $_output;
    }
    
    public static function isLocalExists($key) {
        return isset(self::$viewData->messages->local[$key]);
    }

    public static function viewLocal($key, $outerTag = 'span', $attributes = []) {
        $messages = self::$viewData->messages->local;
        return self::_viewByKey($messages, $key, $outerTag, $attributes);
    }
    
    public static function viewGlobal($key, $outerTag = 'span', $attributes = []) {
        $messages = self::$viewData->messages->global;
        return self::_viewByKey($messages, $key, $outerTag, $attributes);
    }

    public static function viewLocalList($type = null, $attributes = []) {
        $messages = self::$viewData->messages->local;
        return self::_viewList($messages, $type, $attributes);
    }
    
    public static function viewGlobalList($type = null, $attributes = []) {
        $messages = self::$viewData->messages->global;
        return self::_viewList($messages, $type, $attributes);
    }
    
    private static function _viewByKey($messages, $key, $outerTag = 'span', $attributes = []) {
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
    
    private static function _viewList($messages, $type = null, $attributes = []) {
        if (empty($type)) {
            $values = \array_column($messages, 'value');
        }
        else {
            $values = [];
            foreach($messages as $message) {
                if ($message['type'] == $type) {
                    $values[] = $message['value'];
                }
            }
        }
        
        return parent::iterate($values, 'li', $attributes);
    }

}