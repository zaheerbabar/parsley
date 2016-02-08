<?php
namespace Site\Controller;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Helper as Helper;

abstract class BaseController
{
    protected $_resources;
    protected $_viewData;
    private $_globalMessages;
    private $_localMessages;

    const _GLOBAL_RES = '_Global';
    const _MSGS_SESSION = '_messages';

    public function __construct() {
        $this->_viewData = new \stdClass();

        $this->_viewData->user = Components\Auth::getAuthUserData();
        $this->_viewData->data = new \stdClass();
        $this->_viewData->messages = new \stdClass();
        $this->_viewData->messages->global = [];
        $this->_viewData->messages->local = [];

        $this->_globalMessages = [];
        $this->_localMessages = [];

        $this->_resources = new Components\Resources(self::_GLOBAL_RES);
    }
    
    protected function _isPostBack() {
        return (isset($_POST['_postback']) || isset($_GET['_postback']));
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
                if ($class[$i] == 'Controller') $start = true;
            }
            
            $file = implode(DS, $path);
        }

        return $this->_resources->loadFile($file, $lang);
    }

    protected function _responseHTML($data = null, $view, $code = null) {
        if ($data != null) $this->_viewData->data = $data;
        
        $this->_viewData->messages->global = $this->_globalMessages;
        $this->_viewData->messages->local = $this->_localMessages;
        
        if (empty($code) == false) \http_response_code($code);
        
        Helper\BaseHelper::$viewData = $this->_viewData;
        
        return $this->_loadView($this->_viewData, $view);
    }
    
    protected function _responseHTMLError($code, $data = null) {
        return $this->_responseHTML($data, 'error', $code);
    }
    
    protected function _responseJSON($data = null) {
        if ($data != null) $this->_viewData->data = $data;
        
        $this->_viewData->messages->global = $this->_globalMessages;
        $this->_viewData->messages->local = $this->_localMessages;
        
        Helper\BaseHelper::$viewData = $this->_viewData;
        
        return json_encode($this->_viewData);
    }

    private function _loadView($viewData, $view) {
        $_view = realpath(sprintf('%s/View/%s.php', SITE_DIR, $view));
        
        if ($_view == false) {
            throw new \Exception(sprintf('[%s] View template path is not correct.', $view));
        }
        
        ob_start();
        require_once($_view);
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
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
    
    protected function _setGlobalMessage($key = null, $valueKey, $type, $isFlash = false) {
        if ($isFlash) {
            $valueKey = $this->_getFlashValue($valueKey);
        }
        
        if ($this->_resources->isExists($valueKey)) {
            
            $message = ['value' => $this->_resources->get($valueKey), 'type' => $type];
            
            if (empty($key)) {
                $this->_globalMessages[] = $message;
            }
            else {
                $this->_globalMessages[$key] = $message;
            }
        }
    }
    
    protected function _setMessage($key, $valueKey, $type, $isFlash = false) {
        if ($isFlash) {
            $valueKey = $this->_getFlashValue($valueKey);
        }
        
        if ($this->_resources->isExists($valueKey)) {            
            $message = ['value' => $this->_resources->get($valueKey), 'type' => $type];
            
            if (empty($key)) {
                $this->_localMessages[] = $message;
            }
            else {
                $this->_localMessages[$key] = $message;
            }
        }
    }
    
    protected function _setGlobalMessages(array $messages) {
        foreach($messages as $key => $data) {
            $this->_setGlobalMessage($key, $data['key'], $data['type'], $data['flash']);
        }
    }

    protected function _setMessages(array $messages) {
        foreach($messages as $key => $data) {
            $this->_setMessage($key, $data['key'], $data['type'], $data['flash']);
        }
    }

    protected function _setFlashValue($key, $value) {
        Utilities\Session::setSessionValue(self::_MSGS_SESSION, $key, $value);
    }
    
    protected function _setFlashValues($values) {
        foreach($values as $key => $value) {
            $this->_setFlashValue($key, $value);
        }
    }
    
    protected function _getMessage($key) {
        return isset($this->_messages[$key]) ? $this->_messages[$key] : null;
    }

    protected function _getFlashValue($key) {
        return Utilities\Session::getTempValueSession(self::_MSGS_SESSION, $key);
    }
}