<?php

namespace Tperrelli\Encrypt;

use Exception;
use EncryptContract;

class Encrypt implements EncryptContract
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $cipher;

    /**
     * Class constructor
     * 
     * @param string $key
     * @param string $cipher
     */
    public function __construct(string $key, string $cipher)
    {
        $this->key    = $key;
        $this->cipher = $cipher;
    }

    /**
     * Encrypts a public message
     * 
     * @param string $message
     */
    public function encrypt(string $message): array
    {
        if (!in_array($this->cipher, openssl_get_cipher_methods())) 
            throw new Exception("Invalid Cipher");

        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        
        $ciphertext_raw = openssl_encrypt($message, $this->cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv, $tag);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);
        
        return [
            'message' => base64_encode($iv.$hmac.$ciphertext_raw),
            'tag' => $tag
        ];
    }

    /**
     * Decrypts an encrypted message
     * 
     * @param string $message
     * @param string $tag
     */
    public function decrypt(string $message, string $tag): string
    {
        $decoded = base64_decode($message);
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = substr($decoded, 0, $ivlen);
        $hmac = substr($decoded, $ivlen, $sha2len=32);

        $ciphertext_raw = substr($decoded, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $this->cipher, $this->key, $options=OPENSSL_RAW_DATA, $iv, $tag);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->key, $as_binary=true);

        $result = false;

        if (hash_equals($hmac, $calcmac)) {
            $result = $original_plaintext;
        }

        return $result;
    }
}