<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;

abstract class Handler
{
    protected $_resources;
    protected $_viewData;
    private $_messages;

    const _GLOBAL_RES = '_Global';
    const _MSGS_SESSION = '_messages';

    public function __construct() {
        $this->_viewData = new \stdClass();

        $this->_viewData->user = Components\Auth::getAuthUserData();
        $this->_viewData->data = new \stdClass();
        $this->_viewData->messages = [];
        $this->_viewData->flashMessages = [];

        $this->_messages = [];

        $this->_resources = new Components\Resources(self::_GLOBAL_RES);
    }
    
    public function loadResource($file = null, $lang = null) {
        if (empty($file)) {
            $class = explode('\\', get_class($this));

            $path = [];
            $start = false;
            for ($i = 0; $i < count($class); $i++) {
                if ($start) $path[] = $class[$i];
                if ($class[$i] == 'Handlers') $start = true;
            }
            
            $file = implode(DS, $path);
        }

        return $this->_resources->loadFile($file, $lang);
    }

    protected function _responseHTML($data = null) {
        if ($data != null) $this->_viewData->data = $data;
        
        $this->_viewData->messages = $this->_messages;
        return $this->_viewData;
    }
    
    protected function _setMessage($key, $valueKey, $type) {
        
        $this->_messages[$key] = ['value' => $this->_resources->get($valueKey), 
            'type' => $type];
    }

    protected function _setMessages(array $messages) {
        foreach($messages as $key => $data) {
            $this->_setMessage($key, $data['key'], $data['type']);
        }
    }

    protected function _setFlashMessage($key, $value) {
        Utilities\Session::setSessionValue(self::_MSGS_SESSION, $key, $value);
    }

    protected function _setFlashMessages(array $messages) {
        foreach($messages as $key => $value) {
            $this->_setFlashMessage($key, $value);
        }
    }
    
    protected function _getMessage($key) {
        return isset($this->_messages[$key]) ? $this->_messages[$key] : null;
    }

    protected function _getFlashMessage($key) {
        return Utilities\Session::getTempValueSession(self::_MSGS_SESSION, $key);
    }
}