<?php

declare(strict_types=1);

namespace TenantForge\DataObjects;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;

final class CentraUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $global_id = null
    ) {
        if ($global_id === null || $global_id === '' || $global_id === '0') {
            $this->global_id = Str::uuid()->toString();
        }
    }

}
