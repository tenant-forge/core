<?php

declare(strict_types=1);

namespace TenantForge\Filament\Central\Resources\Posts\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use TenantForge\Enums\ContentStatus;
use TenantForge\Filament\Central\Resources\Posts\PostResource;
use TenantForge\Models\Language;
use TenantForge\Models\PostType;

class CreatePost extends CreateRecord
{
    public string $type;

    protected static string $resource = PostResource::class;

    public function mount(): void
    {
        $this->type = request()->route('type') ?? 'posts';

        parent::mount();
    }

    public function getResourceUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = true): string
    {
        /** @var array<string, mixed> $parameters */
        $parameters = [
            ...$parameters,
            'type' => $this->type,
        ];

        return parent::getResourceUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $postType = PostType::query()
            ->where('slug', $this->type)
            ->first();

        /** @var Language $language */
        $language = Language::query()
            ->where('is_default', true)
            ->first();

        if ($postType) {
            $data['post_type_id'] = $postType->id;
            $data['language_id'] = $language->id;
            $data['status'] = ContentStatus::DRAFT;
        }

        return $data;
    }

    protected function getRedirectUrlParameters(): array
    {

        /** @var PostType $postType */
        $postType = PostType::query()
            ->where('slug', $this->type)
            ->first();

        return [
            'type' => $postType->slug,
        ];
    }
}
