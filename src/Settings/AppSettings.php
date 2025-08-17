<?php

declare(strict_types=1);

namespace TenantForge\Settings;

use Spatie\LaravelSettings\Settings;

final class AppSettings extends Settings
{
    public string $name;

    public ?string $domain;

    public ?string $about;

    public string $timezone;

    public string $locale;

    public static function group(): string
    {
        return 'app';
    }
}
