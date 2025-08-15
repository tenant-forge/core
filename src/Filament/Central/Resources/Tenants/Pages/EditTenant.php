<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Tenants\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use TenantForge\Filament\Central\Resources\Tenants\TenantResource;

final class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
