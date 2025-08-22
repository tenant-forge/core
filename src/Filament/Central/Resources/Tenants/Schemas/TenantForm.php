<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Tenants\Schemas;

use Exception;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TenantForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name'),
                TextInput::make('domain')
                    ->label('Domain'),
            ]);
    }
}
