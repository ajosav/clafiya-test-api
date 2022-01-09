<?php

namespace App\Facades;

use App\Helpers\PassportUtil as AuthUtil;
use Illuminate\Support\Facades\Facade;

class PassportUtil extends Facade
{
    public static function getFacadeAccessor()
    {
        return AuthUtil::class;
    }
}