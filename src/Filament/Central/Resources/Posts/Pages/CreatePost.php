<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Pages;

use Filament\Resources\Pages\CreateRecord;
use TenantForge\Filament\Central\Resources\Posts\PostResource;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
