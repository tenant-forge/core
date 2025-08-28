<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Pages\CreatePostType;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Pages\EditPostType;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Pages\ListPostTypes;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Schemas\PostTypeForm;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Tables\PostTypesTable;
use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster;
use TenantForge\Models\PostType;

class PostTypeResource extends Resource
{
    protected static ?string $model = PostType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PostTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostTypesTable::configure($table);
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
            'index' => ListPostTypes::route('/'),
            'create' => CreatePostType::route('/create'),
            'edit' => EditPostType::route('/{record}/edit'),
        ];
    }
}
