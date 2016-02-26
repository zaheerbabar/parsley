<?php
namespace Site\Controller;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Template extends BaseController
{
    public function __construct() {
        parent::__construct();
        
        $this->_setGlobalMessage(null, Objects\MessageType::SUCCESS, Objects\MessageType::SUCCESS, true);
        $this->_setGlobalMessage(null, Objects\MessageType::ERROR, Objects\MessageType::ERROR, true);
        $this->_setGlobalMessage(null, Objects\MessageType::WARNING, Objects\MessageType::WARNING, true);
    }
    
    public function index() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateGet() == false) {
            $this->_setGlobalMessage(null, 'error-request', Objects\MessageType::ERROR);
            return $this->_responseHTMLError(400);
        }
        
        $model = new Model\Template();
        if ($viewData = $model->getByID($_GET['id'])) {
            $viewData->creation_date = Utilities\DateTime::jsDateFormat($viewData->creation_date);
            
            $phaseModel = new Model\Phase();
            $viewData->phases = $phaseModel->getTemplatePhases($viewData->id);
            
            return $this->_responseHTML($viewData, 'template/view');
        }
        
        return $this->_responseHTMLError(404);
    }

    
    public function get() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateGet() == false) {
            $this->_setGlobalMessage(null, 'error-json', Objects\MessageType::ERROR);
            return $this->_responseJSON(null, 400);
        }
        
        $model = new Model\Template();
        if ($viewData = $model->getByID($_GET['id'])) {
            $viewData->creation_date = Utilities\DateTime::jsDateFormat($viewData->creation_date);
            
            return $this->_responseJSON($viewData);
        }
        
        return $this->_responseJSON(null, 404);
    }
    
    public function manage() {
        Components\Auth::redirectUnAuth();
        
        $model = new Model\Template();

        $result = $model->getAll($this->_currentPage($_GET));
        $total = $model->totalCount();
        
        if (empty($result)) {
            $this->_setGlobalMessage(null, 'error-no-record', Objects\MessageType::WARNING);
        }
        
        $this->_setMessage('confirm-delete', 'confirm-delete', Objects\MessageType::CONFIRM);
        
        $viewData = new \stdClass();
        
        $viewData->result = $result;
        $viewData->page = $this->_requestedPage();
        $viewData->total = $total;
        $viewData->pages = $this->_totalPages($total);
        $viewData->limit = PAGE_SIZE;
        
        return $this->_responseHTML($viewData, 'template/list');
    }
    
    public function add() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateAdd() == false) {
            return $this->_responseJSON(null, 400);
        }
        
        $model = new Model\Template();
        
        $template = (object) [
            'title' => $_POST['title'],
            'is_default' => ($_POST['is_default'] == "true")
        ];
        
        if ($model->create($template)) {
            $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-add');
        }

        return $this->_responseJSON();
    }
    
    public function update() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateUpdate() == false) {
            $this->_setGlobalMessage(null, 'error-request', Objects\MessageType::ERROR);
            return $this->_responseJSON(null, 400);
        }
        
        $model = new Model\Template();
        
        $template = (object) [
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'is_default' => ($_POST['is_default'] == "true")
        ];
        
        if ($model->update($template)) {
            $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-update');
        }

        return $this->_responseJSON();
    }
    
    public function delete() {
        if ($this->_isPostBack() == false || $this->_validateDelete() == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
            Components\Path::redirectRoute('template/manage', ['_page' => $this->_requestedPage()]);
        }
        
        $model = new Model\Template();
        
        if ($model->delete($_GET['id'])) {
            $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-delete');
        }
        else {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
        }
        
        Components\Path::redirectRoute('template/manage', ['_page' => $this->_requestedPage()]);
    }
    
    
    private function _validateGet() {
        $isValid = true;
        
        if (empty($_GET['id'])) {
            $isValid = false;
        }
        
        return $isValid;
    }
    
    private function _validateAdd() {
        if (!$this->_validatePrivateRequest()) return false;
        
        $errors = [];
        
        if (empty($_POST['title'])) {
            $errors['title'] = true;
        }
 
        if (empty($errors) == false) {
            $this->_setGlobalMessage(null, 'error-json', Objects\MessageType::WARNING);
            return false;
        }
        
        return true;
    }
    
    private function _validateUpdate() {
        if (!$this->_validatePrivateRequest()) return false;
        
        $errors = [];
        
        if (empty($_POST['id'])) {
             $errors['id'] = true;
        }
        
        if (empty($_POST['title'])) {
            $errors['title'] = true;
        }
 
        if (empty($errors) == false) {
            $this->_setGlobalMessage(null, 'error-json', Objects\MessageType::WARNING);
            return false;
        }
        
        return true;
    }
    
    private function _validateDelete() {
        if (!$this->_validatePrivateRequest(true)) return false;

        $isValid = true;
        
        if (empty($_GET['id'])) {
            $isValid = false;
            
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
        }
        
        return $isValid;
    }
}