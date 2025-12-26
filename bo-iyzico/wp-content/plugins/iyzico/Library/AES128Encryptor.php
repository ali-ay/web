<?php

namespace Iyzico\Library;


class AES128Encryptor
{
    private $_cipher = MCRYPT_RIJNDAEL_128;
    private $_mode = MCRYPT_MODE_ECB;
    private $_key;
    private $_initializationVectorSize;
    public function __construct($key)
    {
        $this->_key = $key;
        $this->_initializationVectorSize = mcrypt_get_iv_size($this->_cipher, $this->_mode);
        if (strlen($key) > ($keyMaxLength = mcrypt_get_key_size($this->_cipher, $this->_mode))) {
            throw new \InvalidArgumentException("The key length must be less or equal than $keyMaxLength.");
        }
    }
    public function encrypt($data)
    {
        $blockSize = mcrypt_get_block_size($this->_cipher, $this->_mode);
        $pad = $blockSize - (strlen($data) % $blockSize);
        $iv = mcrypt_create_iv($this->_initializationVectorSize, MCRYPT_RAND);
        return base64_encode( mcrypt_encrypt(
            $this->_cipher,
            $this->_key,
            $data . str_repeat(chr($pad), $pad),
            $this->_mode
        ));
    }
    public function decrypt($encryptedData)
    {

        $initializationVector = substr($encryptedData, 0, $this->_initializationVectorSize);
        $data =  mcrypt_decrypt(
            $this->_cipher,
            $this->_key,
            substr(base64_decode($encryptedData), $this->_initializationVectorSize),
            $this->_mode,
            $initializationVector
        );
        $pad = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$pad);
    }
}