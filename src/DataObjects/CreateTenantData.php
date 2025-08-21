<?php

declare(strict_types=1);

namespace TenantForge\DataObjects;

use Spatie\LaravelData\Data;

final class CreateTenantData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $domain = null,
    ) {}

}
