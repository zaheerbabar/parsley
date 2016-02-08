<?php
namespace Site\Controller\Workflow;

use Site\Controller as Controller;

class Pattern extends Controller\BaseController
{
    public function index() {
        return $this->_responseHTML(null, 'workflow/patterns');
    }
}