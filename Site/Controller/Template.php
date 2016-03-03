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
        $this->_loadResource();
        
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
        if ($viewData = $model->getByID($this->_requestParam($_GET, 'id'))) {
            $viewData->creation_date = Utilities\DateTime::jsDateFormat($viewData->creation_date);
            
            $phaseModel = new Model\Phase();
            $viewData->phases = $phaseModel->getTemplatePhases($viewData->id, true);
            
            return $this->_responseHTML($viewData, 'template/view');
        }
        
        return $this->_responseHTMLError(404);
    }
    
    public function edit() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateGet() == false) {
            $this->_setGlobalMessage(null, 'error-request', Objects\MessageType::ERROR);
            return $this->_responseHTMLError(400);
        }
        
        $model = new Model\Template();
        if ($viewData = $model->getByID($this->_requestParam($_GET, 'id'))) {
            $viewData->creation_date = Utilities\DateTime::jsDateFormat($viewData->creation_date);
            
            $phaseModel = new Model\Phase();
            $viewData->phases = $phaseModel->getTemplatePhases($viewData->id, true);

            $viewData->json_phases = [];
            foreach($viewData->phases as $phase) {
                
                $contentTypes = [];
                foreach ($phase->content_types as $contentType) {
                    $contentTypes[] = (object) [
                        'id' => $contentType->id,
                        'name' => $contentType->name,
                        'type_id' => $contentType->type_id
                    ];
                }
                
                $jsonPhase = [
                    'id' => $phase->id,
                    'title' => $phase->title,
                    'content_types' => $contentTypes
                ];
                
                $viewData->json_phases[] = rawurlencode(json_encode($jsonPhase));
            }

            $viewData->content_types = $phaseModel->getContentTypes();
            
            return $this->_responseHTML($viewData, 'template/edit');
        }
        
        return $this->_responseHTMLError(404);
    }
    
    public function create() {
        Components\Auth::redirectUnAuth();
        
        $phaseModel = new Model\Phase();
        
        $viewData = new \stdClass();
        $viewData->content_types = $phaseModel->getContentTypes();
            
        return $this->_responseHTML($viewData, 'template/new');
    }
    
    public function save() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateSave() == false) {
            $this->_setGlobalMessage(null, 'error-request', Objects\MessageType::ERROR);
            Components\Path::redirectRoute('template/new');
        }
        
        $model = new Model\Template();
        $phaseModel = new Model\Phase();
        
        $phases = $this->_requestParam($_POST, 'phase');
        
        $_phases = [];
        if (empty($phases) == false) {
            foreach($phases as $phase) {
                $_phases[] = json_decode(rawurldecode($phase));
            }
        }

        $template = (object) [
            'title' => $this->_requestParam($_POST, 'title'),
            'is_default' => ($this->_requestParam($_POST, 'is-default') == true)
        ];
        
        if ($templateId = $model->create($template)) {
            if ($phaseModel->saveTemplatePhases($_phases, $templateId)) {
                $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-save');
            }
        }

        Components\Path::redirectRoute('template/manage');
    }

    public function update() {
        Components\Auth::redirectUnAuth();
        
        if ($this->_isPostBack() == false || $this->_validateUpdate() == false) {
            $this->_setGlobalMessage(null, 'error-request', Objects\MessageType::ERROR);
            Components\Path::redirectRoute('template/edit', ['_postback' => 1, 'id' => $this->_requestParam($_GET, 'id')]);
        }
        
        $model = new Model\Template();
        $phaseModel = new Model\Phase();
        
        $templateId = $this->_requestParam($_GET, 'id');
        $phases = $this->_requestParam($_POST, 'phase');
        
        $_phases = [];
        if (empty($phases) == false) {
            foreach($phases as $phase) {
                $_phases[] = json_decode(rawurldecode($phase));
            }
        }

        $template = (object) [
            'id' => $templateId,
            'title' => $this->_requestParam($_POST, 'title'),
            'is_default' => ($this->_requestParam($_POST, 'is-default') == true)
        ];
        
        if ($model->update($template)) {
            if ($phaseModel->saveTemplatePhases($_phases, $templateId)) {
                $this->_setFlashValue(Objects\MessageType::SUCCESS, 'success-update');
            }
        }

        Components\Path::redirectRoute('template', ['_postback' => 1, 'id' => $this->_requestParam($_GET, 'id')]);
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
    
    public function delete() {
        if ($this->_isPostBack() == false || $this->_validateDelete() == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-delete');
            Components\Path::redirectRoute('template/manage', ['_page' => $this->_requestedPage()]);
        }
        
        $model = new Model\Template();
        
        if ($model->delete($this->_requestParam($_GET, 'id'))) {
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
    
    private function _validateUpdate() {
        if ($this->_validatePublicRequest() == false) return false;
        
        $errors = [];
        
        if (empty($_GET['id'])) {
             $errors['id'] = true;
        }
                
        if (empty($_POST['title'])) {
            $errors['title'] = true;
        }

        if (empty($errors) == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-save');
            return false;
        }
        
        return true;
    }
    
    private function _validateSave() {
        if ($this->_validatePublicRequest() == false) return false;
        
        $errors = [];
        
        if (empty($_POST['title'])) {
            $errors['title'] = true;
        }

        if (empty($errors) == false) {
            $this->_setFlashValue(Objects\MessageType::ERROR, 'error-save');
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