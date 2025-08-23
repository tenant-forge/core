<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Pages;

use BackedEnum;
use Exception;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster;
use TenantForge\Settings\AppSettings;

use function __;

final class AppearanceSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDeviceTablet;

    protected static string $settings = AppSettings::class;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('Appearance');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            SettingsCluster::getUrl() => __('Settings'),
            self::getUrl() => __('Appearance'),
        ];
    }

    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Appearance')
                    ->extraAttributes([
                        'class' => 'tf-settings-section',
                    ])
                    ->inlineLabel()
                    ->schema([
                        FileUpload::make('logo')
                            ->hint(__('The application logo to be shown on the light mode theme.'))
                            ->extraAttributes([
                                'data-test' => 'logo',
                            ])
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->imagePreviewHeight('250')
                            ->removeUploadedFileButtonPosition('right')
                            ->previewable()
                            ->image(),
                        FileUpload::make('dark_logo')
                            ->hint(__('The application logo to be shown on the dark mode theme.'))
                            ->extraAttributes([
                                'data-test' => 'dark-logo',
                            ])
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->previewable()
                            ->imagePreviewHeight('250')
                            ->image(),
                    ]),
            ]);
    }
}
