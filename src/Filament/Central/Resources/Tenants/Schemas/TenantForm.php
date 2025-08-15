<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Tenants\Schemas;

use Filament\Schemas\Schema;

final class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
