<?php

namespace Sciice\Facades;

use Illuminate\Support\Facades\Facade;

class Sciice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sciice';
    }
}
