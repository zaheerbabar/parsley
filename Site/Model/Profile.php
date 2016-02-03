<?php
namespace Site\Model;

use Site\Objects as Objects;

class Profile extends DAL
{
    public function getByUserID($userId) {
        $_profile = $this->_pdo->createQueryBuilder()
            ->select('profile_id', 'profile_first_name', 'profile_last_name', 'profile_phone', 'user_id')
            ->from('profile')
            ->where('user_id = :user_id')
            ->setParameter('user_id', $userId)
            ->execute()
            ->fetch();

        if (!empty($_profile)) {
            return $this->_objectMapper($_profile);
        }

        return null;
    }

    public function create($profile) {
        $values = [
            'profile_first_name' => ':first_name',
            'profile_last_name' => ':last_name',
            'profile_phone' => ':phone',
            'user_id' => ':user_id'
            ];

        $this->_pdo->createQueryBuilder()
            ->insert('profile')
            ->values($values)
            ->setParameter('first_name', $profile->getFirstName())
            ->setParameter('last_name', $profile->getLastName())
            ->setParameter('phone', $profile->getPhone())
            ->setParameter('user_id', $profile->getUserID())
            ->execute();

        return true;
    }

    public function update($profile) {

        $this->_pdo->createQueryBuilder()
            ->update('profile')
            ->set('profile_first_name', ':first_name')
            ->set('profile_last_name', ':last_name')
            ->set('profile_phone', ':phone')
            ->where('user_id = :id')
            ->setParameter('first_name', $profile->getFirstName())
            ->setParameter('last_name', $profile->getLastName())
            ->setParameter('phone', $profile->getPhone())
            ->setParameter('id', $profile->getUserID())
            ->execute();

        return true;
    }

    protected function _objectMapper($data) {
        $obj = new Objects\Profile();

        if (isset($data['profile_id']))
            $obj->setID($data['profile_id']);

        if (isset($data['profile_first_name']))
            $obj->setFirstName($data['profile_first_name']);

        if (isset($data['profile_last_name']))
            $obj->setLastName($data['profile_last_name']);

        if (isset($data['profile_phone']))
            $obj->setPhone($data['profile_phone']);

        if (isset($data['profile_image']))
            $obj->setImage($data['profile_image']);

        if (isset($data['user_id']))
            $obj->setUserID($data['user_id']);

        return $obj;
    }
}