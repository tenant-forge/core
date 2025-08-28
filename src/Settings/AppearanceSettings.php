<?php

declare(strict_types=1);

namespace TenantForge\Settings;

use Spatie\LaravelSettings\Settings;

final class AppearanceSettings extends Settings
{
    public ?string $logo = null;

    public ?string $dark_logo = null;

    public ?string $favicon = null;

    public ?string $primary = null;

    public ?string $secondary = null;

    public ?string $success = null;

    public ?string $danger = null;

    public ?string $warning = null;

    public ?string $info = null;

    public ?string $gray = null;

    public static function group(): string
    {
        return 'appearance';
    }
}
