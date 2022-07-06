<?php

namespace Tperrelli\Encrypt\Facades;

use Illuminate\Support\Facades\Facade;

class Encrypt extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'encrypt';
    }
}