<?php
namespace Site\Controller\Workflow;

use Site\Controller as Controller;
use Site\Components as Components;

class Pattern extends Controller\BaseController
{
    public function index() {
        Components\Auth::redirectUnAuth();
        
        return $this->_responseHTML(null, 'workflow/patterns');
    }
}