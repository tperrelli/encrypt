<?php

namespace Tperrelli\Encrypt\Tests;

use Tperrelli\Encrypt\Encrypt;
use PHPUnit_Framework_TestCase;
use Tperrelli\Encrypt\Exceptions\InvalidCipherException;

class EncryptTest extends PHPUnit_Framework_TestCase
{
    protected $encrypt;

    public function setUp(): void
    {
        $key = md5(mt_rand(0, 1000));
        $cipher = 'aes-128-gcm';

        $this->encrypt = new Encrypt($key, $cipher);
    }

    /**
     * Test encrypt method
     * 
     * @return void
     */
    public function testEncryptMethod(): void
    {
        $message = 'This is a public message';
        
        $hashed = $this->encrypt->encrypt($message);

        $this->assertCount(2, $hashed);
        $this->assertArrayHasKey('message', $hashed);
        $this->assertArrayHasKey('tag', $hashed);
    }

    /**
     * Test decrypt method
     * 
     * @return void
     */
    public function testDecryptMethod(): void
    {
        $message = 'This is a public message';
        
        $encrypted = $this->encrypt->encrypt($message);
        $decrypted = $this->encrypt->decrypt($encrypted['message'], $encrypted['tag']);

        $this->assertSame($message, $decrypted);
    }

    /**
     * Test encrypt with an invalid cipher
     * 
     * @return void
     * @throws InvalidCipherException
     */
    public function testEncryptShouldThrowInvalidCipherException(): void
    {
        $key = 12345;
        $cipher = 'invalid-cipher';
        $message = 'invalid-cipher';

        $encrypt = new Encrypt($key, $cipher);

        try {

            $encrypt->encrypt($message);
        } catch (\Exception $e) {

            $this->assertEquals(422, $e->getCode());
            $this->assertEquals('Invalid Cipher', $e->getMessage());
            $this->assertInstanceOf(InvalidCipherException::class, $e);
        }
    }
}