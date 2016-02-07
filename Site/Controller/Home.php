<?php
namespace Site\Controller;

class Home extends BaseController
{
    public function index() {
        return $this->_responseHTML(null, 'home');
    }
}