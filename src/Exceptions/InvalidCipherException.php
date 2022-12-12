<?php

namespace Tperrelli\Encrypt\Exceptions;

use Exception;

class InvalidCipherException extends Exception
{
    /**
     * Class constructor
     * 
     * @param string $message
     * @param string $code
     */
    public function __construct(string $message, ?int $code = 422)
    {
        parent::__construct($message, $code);
    }
}