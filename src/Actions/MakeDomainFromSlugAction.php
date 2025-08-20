<?php

declare(strict_types=1);

namespace TenantForge\Actions;

use TenantForge\Settings\AppSettings;

final readonly class MakeDomainFromSlugAction
{
    public function __construct(
        private AppSettings $appSettings
    ) {}

    public function handle(string $slug): string
    {
        return $slug.'.'.$this->appSettings->domain;
    }
}
