<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Pages;

use Filament\Resources\Pages\CreateRecord;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\PostTypeResource;

class CreatePostType extends CreateRecord
{
    protected static string $resource = PostTypeResource::class;
}
