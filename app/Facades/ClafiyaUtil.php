<?php

namespace App\Facades;

use App\Helpers\ClafiyaUtil as Util;
use Illuminate\Support\Facades\Facade;

class ClafiyaUtil extends Facade
{
    public static function getFacadeAccessor()
    {
        return Util::class;
    }
}