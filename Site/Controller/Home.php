<?php
namespace Site\Controller;

class Home extends BaseController
{
    public function index() {
        return $this->_responseHTML(null, 'home');
    }
    
    public function error() {
        return $this->_responseHTML(null, 'error');
    }
    
    public function thanks() {
        return $this->_responseHTML(null, 'thanks');
    }
}