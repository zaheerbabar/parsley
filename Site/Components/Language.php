<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;

class Language
{
    const _LANG = '_lang';

    public function select($lang = null) {
        if (empty($lang)) {
            if (empty($_POST[_LANG]) == false) {
                $lang = trim($_POST[_LANG]);    
            }
            
        }

        if ($lang == DEFAULT_LANG)
        Utilities\Cookie::setCookie(self::_LANG, $lang, strtotime('+30 days'));
    }

    public function getSelected() {
        if ($lang = Utilities\Cookie::getCookie(_LANG)) return $lang;
        return false;
    }

    public function isSelected($lang = null) {
        if (empty($lang))
            return Utilities\Cookie::isCookieSet(_LANG);
        
        return (self::getSelected() == $lang);
    }
}