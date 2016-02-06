<?php
namespace Site\Handlers\User;

use Site\Handlers as Handlers;
use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class User extends Handlers\Handler
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
    
}