<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Profile extends Handler
{
    public function __construct() {
        parent::__construct();
        $this->loadResource();
    }

    public function view() {
        Components\Auth::redirectUnAuth();

        $profileModel = new Model\Profile();
        $profile = $profileModel->getByUserID(Components\Auth::getAuthUserData('id'));

        if (empty($profile)) {
            Components\Path::redirectNotFound();
        }

        return $this->_responseHTML($profile);
    }


    public function update() {
        Components\Auth::redirectUnAuth();



        if (empty($profile)) {
            Components\Path::redirectNotFound();
        }

        return $this->_responseHTML($profile);
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


}