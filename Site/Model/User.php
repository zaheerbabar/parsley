<?php
namespace Site\Model;

use Site\Library\Utilities as Utilities;
use Site\Objects as Objects;
use Site\Components as Components;
use Site\Library\Cryptography as Cryptography;
use \Doctrine\DBAL as DBAL;
use Site\Library\Debug as Debug;

class User extends DAL
{
    public function login($user, $roles = null) {
        
        $query = $this->_pdo->createQueryBuilder()
            ->select('user_id', 'user_email', 'user_password')
            ->from('user')
            ->where('user_email = :email')
            ->setParameter('email', $user->getEmail());
            
        if (!empty($roles)) {
            $roles = (is_array($roles)) ? $roles : [$roles];

            $roleQuery = $this->_pdo->createQueryBuilder()
                ->select('*')
                ->from('user_role')
                ->where('user.user_id = user_role.user_id')
                ->andWhere($this->_pdo->createQueryBuilder()->expr()
                        ->in('user_role.role_key', ':roles'));

            $query
                ->andWhere(sprintf('EXISTS (%s)', $roleQuery->getSQL()))
                ->setParameter('roles', $roles, DBAL\Connection::PARAM_STR_ARRAY);
        }
        
        $_user = $query->execute()->fetch();

        $_user = $this->_objectMapper($_user);
        
        if (Components\Auth::validatePassHash($user->getPassword(), $_user->getPassword())) {
            return $this->_onOnline($_user);
        }

        return false;
    }
    
    private function _onOnline($_user) {

        $this->_pdo->createQueryBuilder()
            ->update('user')
            ->set('user_last_online', 'NOW()')
            ->where('user_id = :id')
            ->setParameter('id', $_user->getID())
            ->execute();
        
        $this->_sessionObject($_user);
        
        return true;
    }

    private function _sessionObject($user) {
        $_user = new \stdClass();

        $_user->id = $user->getID();
        $_user->email = $user->getEmail();

        $roles = $this->getRoles($user->getID());
        $_user->roles = $roles;

        $_user->permissions = $this->getPermissions($roles);

        Components\Auth::setAuth($_user);
    }
    
    public function refreshAuth() {
        $user = $this->getCurrent();
        $this->_sessionObject($user);
        
        return true;
    }
    
    public function getCurrent() {
        $userId = Components\Auth::getAuthUserData('id');
        
        $result = $this->_pdo->createQueryBuilder()
        ->select('user_id', 'user_email', 'user_last_online', 'user_creation_date')
        ->from('user')
        ->where('user_id = :id')
        ->setParameter('id', $userId)
        ->execute()
        ->fetch();
        
        return $this->_objectMapper($result);
    }

    public function register($user) {
        $values = [
            'user_email' => ':email',
            'user_password' => ':password',
            'user_creation_date' => 'CURDATE()',
            ];

        $this->_pdo->createQueryBuilder()
            ->insert('user')
            ->values($values)
            ->setParameter('email', $user->getEmail())
            ->setParameter('password', Components\Auth::genPassHash($user->getPassword()))
            ->execute();

        return $this->_pdo->lastInsertId();
    }
    
    public function getAll($page = 1, $skipUserId = null, $keyword = null) {
        $query = $this->_pdo->createQueryBuilder()
            ->select('user_id', 'user_email', 'user_last_online', 'user_creation_date')
            ->from('user');

        if (empty($skipUserId) == false) {
            $query->where('user_id != :id')
                ->setParameter('id', $skipUserId);
        }
        
        $records = $query->setFirstResult($page)
            ->setMaxResults(PAGE_SIZE)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = $this->_objectMapper($row);
        }
        
        return $result;
    }
    
    public function totalCount($skipUserId = null) {
        $query = $this->_pdo->createQueryBuilder()
            ->select('user_id')
            ->from('user');

        if (empty($skipUserId) == false) {
            $query->where('user_id != :id')
                ->setParameter('id', $skipUserId);
        }
        
        return $query->execute()->rowCount();
    }
    
    public function getFiltered($keyword = null) {
        $query = $this->_pdo->createQueryBuilder()
            ->select('user_id', 'user_email', 'user_last_online', 'user_creation_date')
            ->from('user');
            
        if (empty($keyword) == false) {
            $query->where(
                        $this->_pdo->createQueryBuilder()->expr()
                            ->like('user_email', ':email')
                )
                ->setParameter('email', '%'.$keyword.'%');
        }
        
        $records = $query->setMaxResults(PAGE_SIZE)
            ->execute()
            ->fetchAll();
            
        $result = [];

        foreach($records as $row) {
            $result[] = $this->_objectMapper($row);
        }
        
        return $result;
    }
    
    public function getRoles($userId) {
        $roles = $this->_pdo->createQueryBuilder()
            ->select('r.role_id', 'r.role_title', 'r.role_key')
            ->from('role', 'r')
            ->innerJoin('r', 'user_role', 'ur', 'r.role_id = ur.user_role_id')
            ->where('ur.user_id = :id')
            ->setParameter('id', $userId)
            ->execute()
            ->fetchAll();
            
        $_roles = [];
        foreach ($roles as $role) {
            $_roles[] = (object) [
                'id' => $role['role_id'],
                'title' => $role['role_title'],
                'key' => $role['role_key']
            ];
        }

        return $_roles;
    }

    public function getPermissions($roles) {
        
        if (is_array($roles)) {
            if ($roleKeys = Utilities\Data::arrayObjColumn($roles, 'key')) {
                $roles = $roleKeys;
            }
        }
        else {
            $roles = [$roles];
        }

        $permissions = $this->_pdo->createQueryBuilder()
            ->select('p.permission_id', 'p.permission_title', 'p.permission_key')
            ->from('permission', 'p')
            ->innerJoin('p', 'role_permission', 'rp', 'p.permission_key = rp.permission_key')
            ->where(
                $this->_pdo->createQueryBuilder()->expr()
                    ->in('rp.role_key', ':roles')
            )
            ->groupBy('p.permission_key')
            ->setParameter('roles', $roles, DBAL\Connection::PARAM_STR_ARRAY)
            ->execute()
            ->fetchAll();
            
        $_permissions = [];
        foreach ($permissions as $permission) {
            $_permissions[] = (object) [
                'id' => $permission['permission_id'],
                'title' => $permission['permission_title'],
                'key' => $permission['permission_key']
            ];
        }

        return $_permissions;
    }

    public function changePassword($oldPassword, $user) {
        $userId = Components\Auth::getAuthUserData('id');
        $passHash = $this->_pdo->createQueryBuilder()
            ->select('user_password')
            ->from('user')
            ->where('user_id = :id')
            ->setParameter('id', $userId)
            ->execute()
            ->fetchColumn();

        if (Components\Auth::validatePassHash($oldPassword, $passHash) == false) return false;

        $this->_pdo->createQueryBuilder()
            ->update('user')
            ->set('user_password', ':password')
            ->where('user_id = :id')
            ->setParameter('password', Components\Auth::genPassHash($user->getPassword()))
            ->setParameter('id', $accId)
            ->execute();
        
        return true;
    }

    public function resetPassword($user) {
        if (!$this->isEmailExists($user)) return false;

        $this->_pdo->createQueryBuilder()
            ->update('user')
            ->set('user_reset_token', ':token')
            ->where('user_email = :email')
            ->setParameter('email', $user->getEmail())
            ->setParameter('token', Cryptography\Random::genString())
            ->execute();

        $token = $this->_pdo->createQueryBuilder()
            ->select('user_reset_token')
            ->from('user')
            ->where('user_email = :email')
            ->setParameter('email', $user->getEmail())
            ->execute()
            ->fetchColumn();

        if ($token) {
            // Send email
        }

        return $token;
    }

    public function setPassword($user) {
        if (!$this->validateResetToken($user)) return false;

        $this->_pdo->createQueryBuilder()
            ->update('user')
            ->set('user_password', ':password')
            ->set('user_reset_token', '""')
            ->where('user_reset_token = :token')
            ->setParameter('password', Components\Auth::genPassHash($user->getPassword()))
            ->setParameter('token', $user->getToken())
            ->execute();
        
        return true;
    }

    public function validateResetToken($user) {
        $count = $this->_pdo->createQueryBuilder()
            ->select('user_id')
            ->from('user')
            ->where('user_reset_token = :token')
            ->setParameter('token', $user->getToken())
            ->execute()
            ->rowCount();
        
        return ($count > 0) ? true : false;
    }

    public function isEmailExists($user) {
        $count = $this->_pdo->createQueryBuilder()
            ->select('user_id')
            ->from('user')
            ->where('user_email = :email')
            ->setParameter('email', $user->getEmail())
            ->execute()
            ->rowCount();
        
        return ($count > 0) ? true : false;
    }
    
    protected function _objectMapper($data) {
        $obj = new Objects\User();

        if (isset($data['user_id']))
            $obj->setID($data['user_id']);

        if (isset($data['user_email']))
            $obj->setEmail($data['user_email']);

        if (isset($data['user_password']))
            $obj->setPassword($data['user_password']);

        if (isset($data['user_reset_token']))
            $obj->setResetToken($data['user_reset_token']);
            
        if (isset($data['user_verification_token']))
            $obj->setVerificationToken($data['user_verification_token']);

        if (isset($data['user_last_online']))
            $obj->setLastOnline($data['user_last_online']);
            
        if (isset($data['user_creation_date']))
            $obj->setCreationDate($data['user_creation_date']);

        return $obj;
    }
    
}