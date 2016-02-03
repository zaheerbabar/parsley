<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class Project extends Handler
{
    public function viewAll() {
        Components\Auth::redirectUnAuth();
        
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
}