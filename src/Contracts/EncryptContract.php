<?php

namespace Tperrelli\Encrypt\Contracts;

interface EncryptContract
{
    /**
     * Encrypts a public message
     * 
     * @param string $message
     */
    public function encrypt(string $message);

    /**
     * Decrypts an encrypted message
     * 
     * @param string $message
     * @param string $tag
     */
    public function decrypt(string $message, string $tag);
}