<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class User extends Handler
{
    public function __construct() {
        parent::__construct();
        $this->loadResource();
    }

    public function login() {
        Components\Auth::redirectAuth();

        if ($_POST) {
            if ($this->validateLogin() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['pass']);
            
            $userModel = new Model\User();
            
            if (($_user = $userModel->login($user)) != false) {
                Components\Auth::setAuth($_user);

                Components\Path::redirect('/index.php');
            }

            $this->_setMessage('warning', 'error-invalid', 
                Objects\MessageType::WARNING);
        }
        
        return $this->_responseHTML();
    }

    public function logout() {
        Components\Auth::redirectUnAuth();

        if ($this->validateLogout()) {
            Components\Auth::unAuth();
        }
        
        Components\Path::redirect('/index.php');
    }
    
    public function changePassword() {
        Components\Auth::redirectUnAuth();

        if ($_POST) {
            if ($this->validateChangePassword() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $oldPassword = trim($_POST['old-pass']);
            $user->setPassword($_POST['new-pass']);

            $userModel = new Model\User();
            
            if (($userModel->changePassword($oldPassword, $user)) != false) {
                Components\Path::redirect('/index.php');
            }
            
            $this->_setMessage('old-pass', 'error-old-pass', 
                Objects\MessageType::ERROR);
        }
                
        return $this->_responseHTML();
    }

    public function resetPassword() {
        Components\Auth::redirectAuth();

        if ($_POST) {
            if ($this->validateResetPassword() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);

            $userModel = new Model\User();
            
            if (($userModel->resetPassword($user))) {
                Components\Path::redirect('/index.php');
            }
        }
                
        return $this->_responseHTML();
    }

    public function setPassword() {
        Components\Auth::redirectAuth();

        if ($_POST) {
            if ($this->validateSetPassword() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setPassword($_POST['new-pass']);
            $user->setToken($_GET['reset-token']);

            $userModel = new Model\User();
            
            if (($userModel->setPassword($user))) {
                Components\Path::redirect('/index.php');
            }
        }
                
        return $this->_responseHTML();
    }

    public function register() {
        Components\Auth::redirectAuth();

        if ($_POST) {
            if ($this->validateRegister() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['pass']);
            
            $userModel = new Model\User();

            if ($userModel->isEmailExists($user)) {
                $this->_setMessage('email', 'Email already exists.', 
                    Objects\MessageType::ERROR);

                return $this->_responseHTML();
            }

            $userId = $userModel->register($user);

            if ($userId > 0) {
                $profile = new Objects\Profile();
                $profile->setFirstName($_POST['first-name']);
                $profile->setLastName($_POST['last-name']);
                $profile->setPhone($_POST['phone']);
                $profile->setUserID($userId);

                $profileModel = new Model\Profile();

                if ($profileModel->create($profile)) {
                    Components\Path::redirect('thanks.php');
                }
            }

            // If reached here then something is wrong, log error and redirect.
            throw new Exception('Something went wrong while registration.');
        }
                
        return $this->_responseHTML();
    }


    # Request Validations

    private function validateRequest() {
        if (Components\Token::validatePublicToken() == false) {
            $this->_setMessage('warning', 'error-request', 
                Objects\MessageType::WARNING);

            return false;
        }

        return true;
    }

    private function validateLogin() {
        if (!$this->validateRequest()) return false;

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

    private function validateLogout() {
        if (!Components\Token::validatePrivateToken()) return false;

        $errors = [];

        $this->_setFlashMessages($errors);
        
        return empty($errors) ? true : false;
    }

    private function validateRegister() {
        if (!$this->validateRequest()) return false;

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

    private function validateChangePassword() {
        if (!$this->validateRequest()) return false;

        $errors = [];

        //if (Components\Captcha::checkAnswer() == false) {
        //    $errors['captcha'] = 'Captcha is not valid.';
        //}

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

    private function validateResetPassword() {
        if (!$this->validateRequest()) return false;

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

    private function validateSetPassword() {
        if (!$this->validateRequest()) return false;

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