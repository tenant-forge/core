<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Tenants\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use TenantForge\Filament\Central\Resources\Tenants\TenantResource;

final class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
