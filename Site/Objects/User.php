<?php
namespace Site\Objects;

class User
{
    private $id;
    private $email;
    private $password;
    private $token;

    public function getID() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getToken() {
        return $this->token;
    }

    public function setID($id) {
        $this->id = (int) trim($id);
    }

    public function setEmail($email) {
        $this->email = (string) trim($email);
    }

    public function setPassword($password) {
        $this->password = (string) trim($password);
    }

    public function setToken($token) {
        $this->token = (string) trim($token);
    }
}