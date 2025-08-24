<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\Pages;

use Filament\Resources\Pages\CreateRecord;
use TenantForge\Filament\Central\Clusters\Settings\Resources\Languages\LanguageResource;

class CreateLanguage extends CreateRecord
{
    protected static string $resource = LanguageResource::class;
}
