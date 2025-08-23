<?php

declare(strict_types=1);

namespace TenantForge\Settings;

use Spatie\LaravelSettings\Settings;

final class AppSettings extends Settings
{
    public string $name;

    public ?string $domain = null;

    public ?string $logo = null;

    public ?string $dark_logo = null;

    public ?string $favicon = null;

    public ?string $about = null;

    public string $timezone;

    public string $locale;

    public static function group(): string
    {
        return 'app';
    }
}
