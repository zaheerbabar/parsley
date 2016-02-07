<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Project extends Handler
{
    public function __construct() {
        parent::__construct();
    }
    
    public function viewAll() {
        Components\Auth::redirectUnAuth();
        
        $this->_loadMessages();
        
        if ($this->_isPostBack()) {
            $this->_actionCall($this);
        }
        
        $model = new Model\Project();

        $result = $model->getAll($this->_currentPage($_GET));
        $total = $model->totalCount();
        
        if (empty($result)) {
            $this->_setMessage('warning', 'error-no-record', 
                Objects\MessageType::WARNING);
        }
        
        $viewData = new \stdClass();
        
        $viewData->result = $result;
        $viewData->page = $this->_requestedPage($_GET);
        $viewData->total = $total;
        $viewData->pages = $this->_totalPages($total);
        $viewData->limit = PAGE_SIZE;
        
        return $this->_responseHTML($viewData);
    }
    
    protected function _requestHandler($action) {
        switch($action) {
            case 'delete':
                return $this->_delete();
            default:
                return false;
        }
    }
    
    private function _loadMessages() {
        $this->_setMessage('confirm-delete', 'confirm-delete', Objects\MessageType::CONFIRM);
        $this->_setMessage('warning', $this->_getFlashMessage('error-delete'), Objects\MessageType::CONFIRM);
        $this->_setMessage('success', $this->_getFlashMessage('success-delete'), Objects\MessageType::CONFIRM);
    }
    
    private function _delete() {
        if ($this->_validateDelete() == false) {
            return false;
        }
        
        $model = new Model\Project();
        
        if ($model->delete($_GET['id'])) {
            $this->_setFlashMessage('success-delete', 'success-delete');
            
            Components\Path::redirect(sprintf('/project/projects.php?_page=%s', 
                $this->_requestedPage($_GET)));
        }
        
        return false;
    }
    
    private function _validateDelete() {
        if (!$this->_validatePrivateRequest()) return false;

        $errors = [];
        
        if (empty($_GET['id'])) {
            $errors['error-delete'] = 'error-delete';
        }

        $this->_setFlashMessages($errors);
        
        return empty($errors) ? true : false;
    }
}