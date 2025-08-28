<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use TenantForge\Filament\Central\Clusters\Settings\Resources\PostTypes\PostTypeResource;

class ListPostTypes extends ListRecords
{
    protected static string $resource = PostTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
