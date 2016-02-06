<?php
namespace Site\Handlers\User;

use Site\Handlers as Handlers;
use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Setting extends Handlers\Handler
{
    public function __construct() {
        parent::__construct();
        $this->_loadResource();
    }

    public function view() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack()) {
            $this->_actionCall($this);
        }

        $model = new Model\Profile();
        $profile = $model->getByUserID(Components\Auth::getAuthUserData('id'));

        if (empty($profile)) {
            Components\Path::redirectNotFound();
        }

        return $this->_responseHTML($profile);
    }

    protected function _requestHandler($action) {
        switch($action) {
            case 'profile':
                return $this->_updateProfile();
            case 'password':
                return $this->_updatePassword();
        }
    }
    
    private function _updateProfile() {
        if ($this->_validateUpdateProfile() == false) {
            return false;
        }

        $obj = new Objects\Profile();
        $obj->setFirstName($_POST['first-name']);
        $obj->setLastName($_POST['last-name']);
        $obj->setPhone($_POST['phone']);
        $obj->setUserID(Components\Auth::getAuthUserData('id'));
        
        $model = new Model\Profile();
        
        if ($model->update($obj)) {
            
            $this->_setMessage(Objects\MessageType::SUCCESS, 'success-update', 
                Objects\MessageType::SUCCESS);

            return true;
        }
        
        $this->_setMessage(Objects\MessageType::ERROR, 'error-update', 
            Objects\MessageType::ERROR);
        
        return false;
    }
    
    private function _updatePassword() {
        if ($this->_validateUpdatePassword() == false) {
            return false;
        }

        $obj = new Objects\User();
        $oldPass = trim($_POST['old-pass']);
        $obj->setPassword($_POST['new-pass']);

        $model = new Model\User();
        
        if (($model->changePassword($oldPass, $obj)) != false) {
            $this->_setMessage(Objects\MessageType::SUCCESS, 'success-update', 
                Objects\MessageType::SUCCESS);
            
            return true;
        }
        
        $this->_setMessage('old-pass', 'error-old-pass', 
            Objects\MessageType::ERROR);
            
        return false;
    }
    
    
    # Request Validations
    
    private function _validateUpdateProfile() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];
        
        if (empty($_POST['first-name'])) {
            $errors['first-name'] = ['key' => 'error-name', 
                'type' => Objects\MessageType::ERROR];
        }
        
        if (empty($_POST['last-name'])) {
            $errors['last-name'] = ['key' => 'error-name', 
                'type' => Objects\MessageType::ERROR];
        }

        if (empty($_POST['phone'])) {
            $errors['phone'] = ['key' => 'error-phone', 
                'type' => Objects\MessageType::ERROR];
        }

        $this->_setMessages($errors);

        return empty($errors) ? true : false;
    }
    
    private function _validateUpdatePassword() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];
        
        if (empty($_POST['old-pass'])) {
            $errors['old-pass'] = ['key' => 'error-old-pass', 
                'type' => Objects\MessageType::ERROR];
        }
        
        if (empty($_POST['new-pass'])) {
            $errors['new-pass'] = ['key' => 'error-new-pass', 
                'type' => Objects\MessageType::ERROR];
        }

        $this->_setMessages($errors);

        return empty($errors) ? true : false;
    }


}