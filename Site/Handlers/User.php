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
        $this->_loadResource();
    }
    
    public function viewAll() {
        Components\Auth::redirectUnAuth();
        
        $this->_loadMessages();
        
        $model = new Model\User();
        $profileModel = new Model\Profile();

        $currentUserId = Components\Auth::getAuthUserData('id');

        $result = $model->getAll($this->_currentPage($_GET), $currentUserId);
        $total = $model->totalCount($currentUserId);
        
        if (empty($result)) {
            $this->_setMessage('warning', 'error-no-record', Objects\MessageType::WARNING);
                
            return $this->_responseHTML();
        }
        
        $users = [];

        foreach($result as $user) {
            $obj = new \stdClass();
            
            $obj->id = $user->getID();
            $obj->email = $user->getEmail();
            $obj->creation_date = $user->getCreationDate();
            $obj->roles = $model->getRoles($user->getID());
            
            $profile = $profileModel->getByUserID($user->getID());
            
            $obj->name = $profile->getFirstName();
            
            $users[] = $obj;
        }

        $viewData = new \stdClass();
        
        $viewData->result = $users;
        $viewData->page = $this->_requestedPage($_GET);
        $viewData->total = $total;
        $viewData->pages = $this->_totalPages($total);
        $viewData->limit = PAGE_SIZE;
        
        return $this->_responseHTML($viewData);
    }
    
    private function _loadMessages() {
        $this->_setMessage('confirm-delete', 'confirm-delete', Objects\MessageType::CONFIRM);
    }

    public function login() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateLogin() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['pass']);
            
            $model = new Model\User();
            
            if (($_user = $model->login($user)) != false) {
                Components\Auth::setAuth($_user);

                Components\Path::redirect('/index.php');
            }

            $this->_setMessage('warning', 'error-invalid', Objects\MessageType::WARNING);
        }
        
        return $this->_responseHTML();
    }

    public function logout() {
        Components\Auth::redirectUnAuth();

        if ($this->_validateLogout()) {
            Components\Auth::unAuth();
        }
        
        Components\Path::redirect('/index.php');
    }
    
    public function changePassword() {
        Components\Auth::redirectUnAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateChangePassword() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $oldPassword = trim($_POST['old-pass']);
            $user->setPassword($_POST['new-pass']);

            $model = new Model\User();
            
            if (($model->changePassword($oldPassword, $user)) != false) {
                Components\Path::redirect('/index.php');
            }
            
            $this->_setMessage('old-pass', 'error-old-pass', Objects\MessageType::ERROR);
        }
                
        return $this->_responseHTML();
    }

    public function resetPassword() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateResetPassword() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);

            $model = new Model\User();
            
            if (($model->resetPassword($user))) {
                Components\Path::redirect('/index.php');
            }
        }
                
        return $this->_responseHTML();
    }

    public function setPassword() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateSetPassword() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setPassword($_POST['new-pass']);
            $user->setToken($_GET['reset-token']);

            $model = new Model\User();
            
            if (($model->setPassword($user))) {
                Components\Path::redirect('/index.php');
            }
        }
                
        return $this->_responseHTML();
    }

    public function register() {
        Components\Auth::redirectAuth();

        if ($this->_isPostBack()) {
            if ($this->_validateRegister() == false) {
                return $this->_responseHTML();
            }

            $user = new Objects\User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['pass']);
            
            $model = new Model\User();

            if ($model->isEmailExists($user)) {
                $this->_setMessage('email', 'Email already exists.', 
                    Objects\MessageType::ERROR);

                return $this->_responseHTML();
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
                    Components\Path::redirect('thanks.php');
                }
            }

            // If reached here then something is wrong, log error and redirect.
            throw new Exception('Something went wrong while registration.');
        }
                
        return $this->_responseHTML();
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

        $this->_setFlashMessages($errors);
        
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

    private function _validateChangePassword() {
        if (!$this->_validatePublicRequest()) return false;

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