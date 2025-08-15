<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Tenants;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use TenantForge\Filament\Central\Resources\Tenants\Pages\CreateTenant;
use TenantForge\Filament\Central\Resources\Tenants\Pages\EditTenant;
use TenantForge\Filament\Central\Resources\Tenants\Pages\ListTenants;
use TenantForge\Filament\Central\Resources\Tenants\Schemas\TenantForm;
use TenantForge\Filament\Central\Resources\Tenants\Tables\TenantsTable;
use TenantForge\Models\Tenant;

final class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TenantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }
}
