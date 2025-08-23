<?php

declare(strict_types=1);

namespace TenantForge\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TenantForge\Settings\AppSettings;

use function file_get_contents;
use function is_string;

final class AppearanceSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /** @var AppSettings $appSettings */
        $appSettings = app(AppSettings::class);

        $logo = file_get_contents('https://raw.githubusercontent.com/tenant-forge/docs/refs/heads/main/logo/light.svg');
        $darkLogo = file_get_contents('https://raw.githubusercontent.com/tenant-forge/docs/refs/heads/main/logo/dark.svg');
        $favicon = file_get_contents('https://raw.githubusercontent.com/tenant-forge/docs/refs/heads/main/favicon.svg');

        if (! is_string($logo) && ! is_string($darkLogo) && ! is_string($favicon)) {
            return;
        }

        $logoFilePath = 'logos/'.Str::upper(Str::random(16)).'.svg';
        $darkLogoFilePath = 'logos/'.Str::upper(Str::random(16)).'.svg';
        $faviconFilePath = 'logos/'.Str::upper(Str::random(16)).'.svg';

        Storage::disk('public')->put($logoFilePath, $logo);
        Storage::disk('public')->put($darkLogoFilePath, $darkLogo);
        Storage::disk('public')->put($faviconFilePath, $favicon);

        $appSettings->logo = $logoFilePath;
        $appSettings->dark_logo = $darkLogoFilePath;
        $appSettings->favicon = $faviconFilePath;

        $appSettings->save();

    }
}
