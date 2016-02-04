<?php
namespace Site\Handlers\Folder;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Handlers as Handlers;
use Site\Model as Model;

class _Test extends Handlers\Handler
{
    public function __construct() {
        parent::__construct();
        //$this->_loadResource();
    }
    
    public function action() {
        return $this->_actionCall($this);
        
        
        
    }
    
    protected function _requestHandler($action) {
        echo $action;
    }
    
}