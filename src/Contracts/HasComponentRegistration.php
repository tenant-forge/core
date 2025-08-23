<?php

declare(strict_types=1);

namespace TenantForge\Contracts;

interface HasComponentRegistration
{
    public static function registerComponents(string $in, string $for): void;
}
