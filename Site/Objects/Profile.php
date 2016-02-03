<?php
namespace Site\Objects;

class Profile
{
    private $id;
    private $firstName;
    private $lastName;
    private $phone;
    private $image;
    private $userId;

    public function getID() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }
    
    public function getFullName() {
        return trim(sprintf('%s %s', $this->getFirstName(), $this->getLastName()));
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getImage() {
        return $this->image;
    }

    public function getuserID() {
        return $this->userId;
    }

    public function setID($id) {
        $this->id = (int) trim($id);
    }

    public function setFirstName($firstName) {
        $this->firstName = (string) trim($firstName);
    }

    public function setLastName($lastName) {
        $this->lastName = (string) trim($lastName);
    }

    public function setPhone($phone) {
        $this->phone = (string) trim($phone);
    }

    public function setImage($image) {
        $this->image = (string) trim($image);
    }

    public function setUserID($userId) {
        $this->userId = (int) trim($userId);
    }
}