<?php
namespace Site\Library;

class Route
{
    const _KEY = '_route';
    const CLASS_NS = 'Site\\Controller\\';
    const HOME_CLASS = 'Home';
    const INDEX_METHOD = 'index';
    const ERROR_METHOD = 'Error';

    private $_class = null;
    private $_method = null;
    
    public function __construct() {
        $this->_method = self::INDEX_METHOD;
        $this->_class = self::CLASS_NS . self::HOME_CLASS;
        
        $this->_parse();
    }
    
    private function _parse() {
        if (empty($_GET[self::_KEY])) return;
        
        $parts = explode('/', trim($_GET[self::_KEY], '/ '));
        
		while ($parts) {
			$class = self::CLASS_NS . preg_replace('/[^\a-zA-Z0-9]/', '', implode('\\', $parts));

			if (class_exists($class)) {
				$this->_class = $class;
				break;
			}
            else {
				$this->_method = array_pop($parts);
			}
		}
    }
    
    private function _validate() {
        if (substr($this->_method, 0, 2) == '__') {
			return false;
		}
        
        if (is_callable([$this->_class, $this->_method]) == false) {
            return false;
        }
        
        return true;
    }
    
    public function execute() {
        if ($this->_validate()) {
            $controller = new $this->_class();
            echo $controller->{$this->_method}();
        }
        else {
            \http_response_code(404);
            
            $class = self::CLASS_NS . self::HOME_CLASS;
            $controller = new $class();
            echo $controller->{self::ERROR_METHOD}();
        }
    }
}