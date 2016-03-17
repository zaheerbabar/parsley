<?php
namespace Site\Controller;

class Temp extends BaseController
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $viewData = "Hellow World!";
        
        return $this->_responseHTML($viewData, 'temp');
    }
    
    public function something() {
        return "Something...";
    }
    
}