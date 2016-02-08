<?php
namespace Site\Controller\User;

use Site\Controller as Controller;
use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Setting extends Controller\BaseController
{
    public function __construct() {
        parent::__construct();
        $this->_loadResource();
        
        $this->_setGlobalMessage(null, Objects\MessageType::SUCCESS, Objects\MessageType::SUCCESS, true);
        $this->_setGlobalMessage(null, Objects\MessageType::ERROR, Objects\MessageType::ERROR, true);
        
        $this->_setMessage('first-name', 'first-name', Objects\MessageType::ERROR,  true);
        $this->_setMessage('last-name', 'last-name', Objects\MessageType::ERROR,  true);
        $this->_setMessage('phone', 'phone', Objects\MessageType::ERROR,  true);
        $this->_setMessage('old-pass', 'old-pass', Objects\MessageType::ERROR,  true);
        $this->_setMessage('new-pass', 'new-pass', Objects\MessageType::ERROR,  true);
        
    }

    public function index() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack()) {
            //$this->_actionCall($this);
        }

        $model = new Model\Profile();
        $profile = $model->getByUserID(Components\Auth::getAuthUserData('id'));

        if (empty($profile)) {
            return $this->_responseHTMLError(404);
        }

        return $this->_responseHTML($profile, 'user/setting');
    }
    
    public function updateProfile() {
        if ($this->_isPostBack() == false || $this->_validateUpdateProfile() == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-update');
            Components\Path::redirectRoute('user/setting');
        }

        $obj = new Objects\Profile();
        $obj->setFirstName($_POST['first-name']);
        $obj->setLastName($_POST['last-name']);
        $obj->setPhone($_POST['phone']);
        $obj->setUserID(Components\Auth::getAuthUserData('id'));
        
        $model = new Model\Profile();
        
        if ($model->update($obj)) {
            $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-update');
        }
        else {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-update');
        }
        
        Components\Path::redirectRoute('user/setting');
    }
    
    public function updatePassword() {
        if ($this->_isPostBack() == false || $this->_validateUpdatePassword() == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-update');
            Components\Path::redirectRoute('user/setting');
        }

        $obj = new Objects\User();
        $oldPass = trim($_POST['old-pass']);
        $obj->setPassword($_POST['new-pass']);

        $model = new Model\User();
        
        if (($model->changePassword($oldPass, $obj)) != false) {
            $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-update');
        }
        else {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-update');
            $this->_setFlashValue('old-pass', 'error-old-pass');
        }

        Components\Path::redirectRoute('user/setting');
    }
    
    
    # Request Validations
    
    private function _validateUpdateProfile() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];
        
        if (empty($_POST['first-name'])) {
            $errors['first-name'] = 'error-name';
        }
        
        if (empty($_POST['last-name'])) {
            $errors['last-name'] = 'error-name';
        }

        if (empty($_POST['phone'])) {
            $errors['phone'] = 'error-phone';
        }

        $this->_setFlashValues($errors);

        return empty($errors) ? true : false;
    }
    
    private function _validateUpdatePassword() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];
        
        if (empty($_POST['old-pass'])) {
            $errors['old-pass'] = 'error-old-pass';
        }
        
        if (empty($_POST['new-pass'])) {
            $errors['new-pass'] = 'error-new-pass';
        }

        $this->_setFlashValues($errors);

        return empty($errors) ? true : false;
    }
}