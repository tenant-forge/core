<?php

namespace TenantForge\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TenantForge\TenantForge
 */
class TenantForge extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TenantForge\TenantForge::class;
    }
}
