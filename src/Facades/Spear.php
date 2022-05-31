<?php

namespace Redberry\Spear\Facades;

use Illuminate\Support\Facades\Facade;

class Spear extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'redberry.spear';
    }
}