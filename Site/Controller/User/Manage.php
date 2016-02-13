<?php
namespace Site\Controller\User;

use Site\Controller as Controller;
use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Manage extends Controller\BaseController
{
    public function __construct() {
        Components\Auth::redirectUnAuth();
        
        parent::__construct();
        $this->_loadResource();
        
        $this->_setGlobalMessage(null, Objects\MessageType::SUCCESS, Objects\MessageType::SUCCESS, true);
        $this->_setGlobalMessage(null, Objects\MessageType::ERROR, Objects\MessageType::ERROR, true);
        
        $this->_setMessage('confirm-delete', 'confirm-delete', Objects\MessageType::CONFIRM);
    }
    
    public function index() {
        $model = new Model\User();
        $profileModel = new Model\Profile();

        $currentUserId = Components\Auth::getAuthUserData('id');

        $result = $model->getAll($this->_currentPage($_GET), $currentUserId);
        $total = $model->totalCount($currentUserId);
        
        if (empty($result)) {
            $this->_setGlobalMessage(null, 'error-no-record', Objects\MessageType::WARNING);
                
            return $this->_responseHTML(null, 'user/manage');
        }
        
        $users = [];

        foreach($result as $user) {
            $obj = new \stdClass();
            
            $obj->id = $user->getID();
            $obj->email = $user->getEmail();
            $obj->last_online = $user->getLastOnline();
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
        
        return $this->_responseHTML($viewData, 'user/manage');
    }
    
}