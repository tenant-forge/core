<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Pages;

use BackedEnum;
use Exception;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster;
use TenantForge\Settings\AppSettings;

use function __;

final class GeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = AppSettings::class;

    protected static ?string $cluster = SettingsCluster::class;

    public static function getNavigationLabel(): string
    {
        return __('General Settings');
    }

    public function getTitle(): string
    {
        return __('General Settings');
    }

    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('General')
                    ->extraAttributes([
                        'class' => 'tf-settings-section',
                    ])
                    ->inlineLabel()
                    ->schema([
                        TextInput::make('name')
                            ->hint(__('The name of the application.'))
                            ->required(),
                        TextInput::make('domain')
                            ->hint(__('The domain of the application.')),
                        MarkdownEditor::make('about')
                            ->hint(__('A short description of the application. This will also be used for the meta description.')),
                    ]),

                Section::make('Localization')
                    ->extraAttributes([
                        'class' => 'tf-settings-section',
                    ])
                    ->inlineLabel()
                    ->schema([
                        TextInput::make('timezone')
                            ->hint(__('The timezone of the application.'))
                            ->required(),
                        TextInput::make('locale')
                            ->hint(__('The locale of the application.'))
                            ->required(),
                    ]),
            ]);
    }
}
