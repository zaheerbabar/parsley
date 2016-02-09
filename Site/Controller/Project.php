<?php
namespace Site\Controller;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Project extends BaseController
{
    public function __construct() {
        parent::__construct();
        
        $this->_setGlobalMessage(null, Objects\MessageType::SUCCESS, Objects\MessageType::SUCCESS, true);
        $this->_setGlobalMessage(null, Objects\MessageType::ERROR, Objects\MessageType::ERROR, true);
        
        $this->_setMessage('confirm-delete', 'confirm-delete', Objects\MessageType::CONFIRM);
    }
    
    public function index() {
        Components\Auth::redirectUnAuth();
        
        $model = new Model\Project();

        $result = $model->getAll($this->_currentPage($_GET));
        $total = $model->totalCount();
        
        if (empty($result)) {
            $this->_setGlobalMessage(null, 'error-no-record', Objects\MessageType::WARNING);
        }
        
        $viewData = new \stdClass();
        
        $viewData->result = $result;
        $viewData->page = $this->_requestedPage($_GET);
        $viewData->total = $total;
        $viewData->pages = $this->_totalPages($total);
        $viewData->limit = PAGE_SIZE;
        
        return $this->_responseHTML($viewData, 'project/list');
    }
    
    public function delete() {
        if ($this->_isPostBack() == false || $this->_validateDelete() == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
            Components\Path::redirectRoute('project', ['_page' => $this->_requestedPage($_GET)]);
        }
        
        $model = new Model\Project();
        
        if ($model->delete($_GET['id'])) {
            $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-delete');
        }
        else {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
        }
        
        Components\Path::redirectRoute('project', ['_page' => $this->_requestedPage($_GET)]);
    }
    
    private function _validateDelete() {
        if (!$this->_validatePrivateRequest()) return false;

        $isValid = true;
        
        if (empty($_GET['id'])) {
            $isValid = false;
            
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
        }
        
        return $isValid;
    }
}