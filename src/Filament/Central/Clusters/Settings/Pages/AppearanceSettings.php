<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Pages;

use BackedEnum;
use Exception;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use TenantForge\Filament\Central\Clusters\Settings\SettingsCluster;

use function __;

final class AppearanceSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string $settings = \TenantForge\Settings\AppearanceSettings::class;

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
            self::getUrl() => __('Logos'),
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
                Section::make(__('Colors'))
                    ->extraAttributes([
                        'class' => 'tf-settings-section',
                    ])
                    ->inlineLabel()
                    ->schema([
                        ColorPicker::make('danger')
                            ->label(__('Danger'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                        ColorPicker::make('gray')
                            ->label(__('Gray'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                        ColorPicker::make('info')
                            ->label(__('Info'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                        ColorPicker::make('primary')
                            ->label(__('Primary'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                        ColorPicker::make('secondary')
                            ->label(__('Secondary'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                        ColorPicker::make('success')
                            ->label(__('Success'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                        ColorPicker::make('warning')
                            ->label(__('Warning'))
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/'),
                    ]),
                Section::make(__('Logos and Favicon'))
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
                        FileUpload::make('favicon')
                            ->hint(__('The application favicon.'))
                            ->extraAttributes([
                                'data-test' => 'favicon',
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
