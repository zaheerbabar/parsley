<?php
namespace Site\Library\Cryptography;

class Crypt
{
    private $_key;
    private $_iv;

    public function __construct($key = null, $iv = null) {
        
        if (empty($key) || empty($iv)) {
            $this->_key = pack('H*', '59fe5e59b9eb992ade848305176f963ff6182acb5bca5632b2133d9f7b856020');
            $this->_iv = pack('H*', '5569f385c70adfc22893046ad0a8b24e');
        }
        else {
            $this->_key = pack('H*', $key);
            $this->_iv = pack('H*', $iv);
        }
    }

    public function generateKey() {
        $keySize = mcrypt_get_key_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CFB);

        $strong = false;
        do {
            $key = openssl_random_pseudo_bytes($keySize, $strong);
        } while ($strong == false);
        
        return bin2hex($key);
    }

    public function generateIV() {
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CFB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);

        return bin2hex($iv);
    }
    
    public function encrypt($data) {
        if (empty($data)) {
            return null;
        }
        
        return trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_key, base64_encode(trim(serialize($data))), MCRYPT_MODE_CFB, $this->_iv));
    }
    
    public function decrypt($data) {
        if (empty($data)) {
            return null;
        }

        return unserialize(base64_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_key, $data, MCRYPT_MODE_CFB, $this->_iv))));
    }
}