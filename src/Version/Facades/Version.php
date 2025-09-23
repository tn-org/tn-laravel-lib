<?php

namespace Tnlake\Lib\Version\Facades;

use Illuminate\Support\Facades\Facade;

class Version extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tnlake\Lib\Version\Contracts\VersionChecker::class;
    }
}
