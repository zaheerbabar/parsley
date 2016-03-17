<?php
namespace Site\Controller;

use Site\Model as Model;

class Temp extends BaseController
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $model = new Model\Temp();
        
        $viewData = $model->getPatterns();
        
        return $this->_responseHTML($viewData, 'temp');
    }
    
    public function something() {
        
        $viewData = "some data";
        
        return $this->_responseJSON($viewData);
    }
    
}