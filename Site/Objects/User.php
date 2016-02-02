<?php
namespace Site\Objects;

class User
{
    private $_id;
    private $_email;
    private $_password;
    private $_resetToken;
    private $_verificationToken;
    private $_creationDate;

    public function getID() {
        return $this->_id;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getResetToken() {
        return $this->_resetToken;
    }
    
    public function getVerificationToken() {
        return $this->_verificationToken;
    }
    
    public function getCreationDate() {
        return $this->_creationDate;
    }

    public function setID($id) {
        $this->_id = (int) trim($id);
    }

    public function setEmail($email) {
        $this->_email = (string) trim($email);
    }

    public function setPassword($password) {
        $this->_password = (string) trim($password);
    }

    public function setResetToken($token) {
        $this->_resetToken = (string) trim($token);
    }
    
    public function setVerificationToken($token) {
        $this->_verificationToken = (string) trim($token);
    }
    
    public function setCreationDate($date) {
        $this->_creationDate = trim($date);
    }
}