<?php
namespace Site\Controller;

use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Pattern extends BaseController
{
    public function index() {
        Components\Auth::redirectUnAuth();
        
        $model = new Model\Pattern();

        $result = $model->getAll($this->_currentPage($_GET), Components\Auth::getAuthUserData('id'));
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
        
        return $this->_responseHTML($viewData, 'pattern/list');
    }
    
    public function manage() {
        Components\Auth::redirectUnAuth();
        
        $model = new Model\Pattern();

        $result = $model->getAll($this->_currentPage($_GET), Components\Auth::getAuthUserData('id'));
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
        
        return $this->_responseHTML($viewData, 'pattern/list');
    }
}