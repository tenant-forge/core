<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Filament\Central\Resources\Posts\PostResource;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    public function getResourceUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = true): string
    {
        /** @var array<string, mixed> $parameters */
        $parameters = [
            ...$parameters,
            'type' => PostResource::getPostType()->slug,
        ];

        return parent::getResourceUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['post_type_id'] = PostResource::getPostType()->id;

        return $data;
    }

    protected function getRedirectUrlParameters(): array
    {
        return [
            'type' => PostResource::getPostType()->slug,
        ];
    }
}
