<?php
namespace Site\Handlers;

use Site\Library\Utilities as Utilities;
use Site\Components as Components;
use Site\Objects as Objects;
use Site\Model as Model;

class User extends Handler
{
    public function __construct() {
        parent::__construct();
        $this->_loadResource();
    }
    
    
    
}