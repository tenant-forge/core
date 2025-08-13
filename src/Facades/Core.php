<?php

namespace TenantForge\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TenantForge\Core\Core
 */
class Core extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TenantForge\Core\Core::class;
    }
}
