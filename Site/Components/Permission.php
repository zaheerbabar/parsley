<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;

class Permission
{
    public static function inRoles($roles) {
        if (Utilities\Session::isSessionSet(Auth::_AUTH)) {
            $user = \unserialize(Utilities\Session::getSession(Auth::_AUTH));
            
            $roles = (is_array($roles)) ? $roles : [$roles];

            foreach ($roles as $role) {
                if (Utilities\Data::inArray($role, $user->roles))
                    return true;
            }
        }
        
        return false;
    }
    
    public static function hasPermissions($permissions) {
        $permissions = (is_array($permissions)) ? $permissions : [$permissions];

        $_permissions = self::getPermissions();
        if (empty($_permissions)) return false;

        foreach ($permissions as $permission) {    
            if (Utilities\Data::inArray($permission, $_permissions) == false)
                return false;
        }

        return true;
    }

    public static function getPermissions() {
        if (Utilities\Session::isSessionSet(Auth::_AUTH)) {
            $user = \unserialize(Utilities\Session::getSession(Auth::_AUTH));

            return $user->permissions;
        }

        return null;
    }


    
}