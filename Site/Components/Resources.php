<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;

class Resources
{
    //  header('Content-language: en');
    // Accept-Language: en-US,en;q=0.5

    // http://stackoverflow.com/questions/5423989/proper-use-of-php-headercontent-language

    // http://scriptdigital.com/divers/phplocalization.html
    // http://www.onlamp.com/pub/a/php/2002/11/28/php_i18n.html?page=1
    // http://www.sitepoint.com/localizing-javascript-strings-php-mvc-framework/

    private $_resources;

    const _DIR = 'Resources';

    public function __construct($file, $lang = null) {
        $this->loadFile($file, $lang);
    }

    public function loadFile($file, $lang = null) {
        $file = Utilities\File::getWithoutExtension($file);

        $path = realpath(sprintf('%s%s%s.json', SITE_DIR.DS.self::_DIR.DS, $lang, $file));

        if ($path !== false) {
            if ($resources = json_decode(file_get_contents($path), true)) {
                if (empty($this->_resources)) {
                    $this->_resources = $resources;
                }
                else {
                    $this->_resources = array_merge($this->_resources, $resources);
                }

                return true;
            }
            
            throw new \Exception(sprintf('Unable to parse %s.json resource file.', $file));
        }

        return false;
    }

    public function getAll() {
        return (object) $this->_resources;
    }

    public function get($key) {
        if ($this->isExists($key))
            return $this->_resources[$key];
            
        return null;
    }

    public function isExists($key) {
        return isset($this->_resources[$key]);
    }
}