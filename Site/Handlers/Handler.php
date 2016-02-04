<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;

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
    
    protected function _isPostBack() {
        return ($_POST || $_GET);
    }
    
    protected function _actionCall($object, $handler = '_requestHandler') {
        $action = null;
        
        if (empty($_GET['_action']) == false) {
            $action = trim(strtolower($_GET['_action']));
        }
        elseif (empty($_POST['_action']) == false) {
            $action = trim(strtolower($_POST['_action']));
        }

        if (\method_exists($object, $handler)) {
            $object->{$handler}($action);
        }
    }
    
    protected function _requestedPage($request, $key = '_page') {
        if (!empty($request[$key])) {
            $page = (int)trim($request[$key]);
            
            return $page;
        }
        
        return 1;
    }
    
    protected function _currentPage($request, $key = '_page') {
        $page = $this->_requestedPage($request, $key);
        return ($page - 1) * PAGE_SIZE;
    }
    
    protected function _totalPages($totalCount) {
        return ceil($totalCount / PAGE_SIZE);
    }
    
    protected function _loadResource($file = null, $lang = null) {
        if (empty($file)) {
            $class = explode('\\', \get_class($this));

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
    
    protected function _validatePublicRequest($flashMessage = false) {
        if (Components\Token::validatePublicToken() == false) {
            if ($flashMessage) {
                $this->_setFlashMessage('warning', 'error-request');
            }
            
            $this->_setMessage('warning', 'error-request', 
                    Objects\MessageType::WARNING);
            
            return false;
        }

        return true;
    }
    
    protected function _validatePrivateRequest($flashMessage = false) {
        if (Components\Token::validatePrivateToken() == false) {
            if ($flashMessage) {
                $this->_setFlashMessage('warning', 'error-request');
            }
            
            $this->_setMessage('warning', 'error-request', 
                    Objects\MessageType::WARNING);
            
            return false;
        }

        return true;
    }
    
    protected function _setMessage($key, $valueKey, $type) {
        if ($this->_resources->isExists($valueKey)) {
            $this->_messages[$key] = ['value' => $this->_resources->get($valueKey), 
                'type' => $type];
        }
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