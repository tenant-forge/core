<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\Languages;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Pages\CreateLanguage;
use TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Pages\EditLanguage;
use TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Pages\ListLanguages;
use TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Schemas\LanguageForm;
use TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Tables\LanguagesTable;
use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster;
use TenantForge\Models\Language;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string
    {
        return __('Localization');
    }

    public static function form(Schema $schema): Schema
    {
        return LanguageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LanguagesTable::configure($table);
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
            'index' => ListLanguages::route('/'),
            'create' => CreateLanguage::route('/create'),
            'edit' => EditLanguage::route('/{record}/edit'),
        ];
    }
}
