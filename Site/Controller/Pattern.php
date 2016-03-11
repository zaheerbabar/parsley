<?php
namespace Site\Controller;

use Site\Components as Components;

class Pattern extends BaseController
{
    public function index() {
        Components\Auth::redirectUnAuth();
        
        return $this->_responseHTML(null, 'workflow/patterns');
    }
}