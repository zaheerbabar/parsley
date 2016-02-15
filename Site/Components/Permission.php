<?php
namespace Site\Components;

use Site\Library\Utilities as Utilities;

class Permission
{
    public static function inRoles($roles) {
        if (Utilities\Session::isSessionSet(Auth::_AUTH)) {
            $user = \unserialize(Utilities\Session::getSession(Auth::_AUTH));
            $_roleKeys = Utilities\Data::arrayObjColumn($user->roles, 'key');
            
            $roles = (is_array($roles)) ? $roles : [$roles];
            foreach ($roles as $role) {
                if (Utilities\Data::inArray($role, $_roleKeys))
                    return true;
            }
        }
        
        return false;
    }
    
    public static function hasPermissions($permissions) {
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        $_permissions = self::getPermissions('key');
        if (empty($_permissions)) return false;

        foreach ($permissions as $permission) {    
            if (Utilities\Data::inArray($permission, $_permissions) == false)
                return false;
        }

        return true;
    }

    public static function getPermissions($key = null) {
        if (Utilities\Session::isSessionSet(Auth::_AUTH)) {
            $user = \unserialize(Utilities\Session::getSession(Auth::_AUTH));
            $permissions = $user->permissions;

            if (empty($key) == false) {
                return Utilities\Data::arrayObjColumn($permissions, $key);
            }
            
            return $permissions;
        }

        return null;
    }
    
}