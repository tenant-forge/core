<?php

declare(strict_types=1);

namespace TenantForge\Core;

use function function_exists;

if (! function_exists('TenantForge\Core\source_path')) {
    /**
     * Get the path to the package "src" directory.
     */
    function source_path(?string $path = null): string
    {
        $basePath = __DIR__;

        return $path ? $basePath . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $basePath;
    }
}
