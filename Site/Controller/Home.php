<?php
namespace Site\Controller;

use Site\Components as Components;

class Home extends BaseController
{
    public function index() {
        if (Components\Auth::isAuth()) {
            return $this->_responseHTML(null, 'home');
        }
        
        return $this->_responseHTML(null, 'user/login');
    }
    
    public function home() {
        return $this->_responseHTML(null, 'home');
    }
    
    public function error() {
        return $this->_responseHTML(null, 'error');
    }
    
    public function thanks() {
        return $this->_responseHTML(null, 'thanks');
    }
}