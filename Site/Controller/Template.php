<?php
namespace Site\Controller;

use Site\Components as Components;

class Template extends BaseController
{
    public function add() {
        Components\Auth::redirectUnAuth();
        
        return $this->_responseHTML(null, 'template/add');
    }
}