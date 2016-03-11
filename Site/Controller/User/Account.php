<?php
namespace Site\Controller\User;

use Site\Controller as Controller;
use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Account extends Controller\BaseController
{
    public function __construct() {
        parent::__construct();
        $this->_loadResource();
    }
    
    public function login() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateLogin() == false) {
                return $this->_responseHTML(null, 'user/login');
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['pass']);
            
            $model = new Model\User();
            
            if (($model->login($user)) != false) {                
                Components\Path::redirectRoute('pattern');
            }

            $this->_setMessage('warning', 'error-invalid', Objects\MessageType::ERROR);
        }
        
        return $this->_responseHTML(null, 'user/login');
    }

    public function logout() {
        Components\Auth::redirectUnAuth();

        if ($this->_validateLogin() == false && $this->_validateLogout()) {
            Components\Auth::unAuth();
        }
        
        Components\Path::redirectRoute();
    }
    
    public function resetPassword() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateResetPassword() == false) {
                return $this->_responseHTML(null, 'user/reset-password');
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);

            $model = new Model\User();
            
            $this->_setMessage(Objects\MessageType::SUCCESS, 'success-pass-reset', 
                Objects\MessageType::SUCCESS);
            
            // if (($model->resetPassword($user))) {
            //     
            // }
        }
        
        return $this->_responseHTML(null, 'user/reset-password');
    }

    public function setPassword() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateSetPassword() == false) {
                return $this->_responseHTML(null, 'user/set-password');
            }

            $user = new Objects\User();
            $user->setPassword($_POST['new-pass']);
            $user->setToken($_GET['reset-token']);

            $model = new Model\User();
            
            if (($model->setPassword($user))) {
                Components\Path::redirectRoute();
            }
        }
                
        return $this->_responseHTML(null, 'user/set-password');
    }

    public function register() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateRegister() == false) {
                return $this->_responseHTML(null, 'user/register');
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['pass']);
            
            $model = new Model\User();

            if ($model->isEmailExists($user)) {
                $this->_setMessage('email', 'error-email-exists', 
                    Objects\MessageType::ERROR);

                return $this->_responseHTML(null, 'user/register');
            }

            $userId = $model->register($user);

            if ($userId > 0) {
                $profile = new Objects\Profile();
                $profile->setFirstName($_POST['first-name']);
                $profile->setLastName($_POST['last-name']);
                $profile->setPhone($_POST['phone']);
                $profile->setUserID($userId);

                $profileModel = new Model\Profile();

                if ($profileModel->create($profile)) {
                    Components\Path::redirectRoute('home/thanks');
                }
            }

            // If reached here then something is wrong, log error and redirect.
            throw new Exception('Something went wrong while registration.');
        }
                
        return $this->_responseHTML(null, 'user/register');
    }


    # Request Validations

    private function _validateLogin() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];
        
        if (empty($_POST['email'])) {
            $errors['email'] = ['key' => 'error-email', 
                'type' => Objects\MessageType::ERROR];
        }

        if (empty($_POST['pass'])) {
            $errors['pass'] = ['key' => 'error-pass', 
                'type' => Objects\MessageType::ERROR];
        }

        $this->_setMessages($errors);

        return empty($errors) ? true : false;
    }

    private function _validateLogout() {
        if (!$this->_validatePrivateRequest()) return false;

        $errors = [];

        $this->_setFlashValues($errors);
        
        return empty($errors) ? true : false;
    }

    private function _validateRegister() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];

        //if (Components\Captcha::checkAnswer() == false) {
        //    $errors['captcha'] = 'Captcha is not valid.';
        //}

        if (empty($_POST['email'])) {
            $errors['email'] = ['key' => 'error-email', 
                'type' => Objects\MessageType::ERROR];
        }

        if (empty($_POST['pass'])) {
            $errors['pass'] = ['key' => 'error-pass', 
                'type' => Objects\MessageType::ERROR];
        }

        if (empty($_POST['first-name'])) {
            $errors['first-name'] = ['key' => 'error-first-name', 
                'type' => Objects\MessageType::ERROR];
        }

        if (empty($_POST['last-name'])) {
            $errors['last-name'] = ['key' => 'error-last-name', 
                'type' => Objects\MessageType::ERROR];
        }

        if (empty($_POST['phone'])) {
            $errors['phone'] = ['key' => 'error-phone', 
                'type' => Objects\MessageType::ERROR];
        }

        $this->_setMessages($errors);

        return empty($errors) ? true : false;
    }
    
    private function _validateResetPassword() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];

        //if (Components\Captcha::checkAnswer() == false) {
        //    $errors['captcha'] = 'Captcha is not valid.';
        //}
        
        if (empty($_POST['email'])) {
            $errors['email'] = ['key' => 'error-email', 
                'type' => Objects\MessageType::ERROR];
        }

        $this->_setMessages($errors);

        return empty($errors) ? true : false;
    }

    private function _validateSetPassword() {
        if (!$this->_validatePublicRequest()) return false;

        $errors = [];

        //if (Components\Captcha::checkAnswer() == false) {
        //    $errors['captcha'] = 'Captcha is not valid.';
        //}
        
        if (empty($_POST['new-pass'])) {
            $errors['new-pass'] = ['key' => 'error-new-pass', 
                'type' => Objects\MessageType::ERROR];
        }

        $this->_setMessages($errors);

        return empty($errors) ? true : false;
    }
}