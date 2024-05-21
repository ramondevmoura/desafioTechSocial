<?php

class CryptoService
{
    private $encryptionKey;

    public function __construct($encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;
    }

    public function encrypt($data)
    {
        return openssl_encrypt($data, 'aes-256-cbc', $this->encryptionKey, 0, substr($this->encryptionKey, 0, 16));
    }

    public function decrypt($data)
    {
        // Verifique se os dados não são null antes de descriptografar
        if ($data !== null) {
            return openssl_decrypt($data, 'aes-256-cbc', $this->encryptionKey, 0, substr($this->encryptionKey, 0, 16));
        } else {
            return null; // Retorna null se os dados forem null
        }
    }


    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}