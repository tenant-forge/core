<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Filament\Actions\LanguageSelector;
use TenantForge\Filament\Central\Resources\Posts\PostResource;
use TenantForge\Models\Post;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    public function getResourceUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = true): string
    {

        /** @var Post $post */
        $post = $this->getRecord();

        /** @var array<string, mixed> $parameters */
        $parameters = [
            ...$parameters,
            'type' => $post->type->slug,
        ];

        return parent::getResourceUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    public function booted(): void
    {
        /** @var Post $post */
        $post = $this->getRecord();

        request()->route()?->setParameter('type', $post->type->slug);
    }

    protected function getRedirectUrl(): string
    {

        /** @var Post $post */
        $post = $this->getRecord();

        return PostResource::getUrl('edit', [
            'record' => $post,
            'type' => $post->type->slug,
        ]);
    }

    protected function getHeaderActions(): array
    {

        /** @var Post $post */
        $post = $this->getRecord();

        return [

            LanguageSelector::make('language-selector')
                ->setView($post),
            DeleteAction::make(),
        ];
    }
}
