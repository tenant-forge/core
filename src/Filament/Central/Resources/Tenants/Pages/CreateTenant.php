<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Tenants\Pages;

use Filament\Resources\Pages\CreateRecord;
use TenantForge\Filament\Central\Resources\Tenants\TenantResource;

final class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;
}
