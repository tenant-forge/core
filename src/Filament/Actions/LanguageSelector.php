<?php

declare(strict_types=1);

namespace TenantForge\Filament\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
use TenantForge\Models\Language;
use TenantForge\Models\Post;

class LanguageSelector extends Action
{
    private ?Post $translatableRecord = null;

    private ?Post $originalTranslatableRecord = null;

    /**
     * @var null|Collection<int, Post>
     */
    private ?Collection $translations = null;

    /**
     * @var Collection<int, Language>|null
     */
    private ?Collection $missingTranslations = null;

    public function setUp(): void
    {
        parent::setUp();

        if ($this->translatableRecord instanceof Post) {
            $this->view('tenantforge::filament.actions.language-selector', [
                'post' => $this->translatableRecord,
            ]);
        }
    }

    public function setTranslatableRecord(Post $post): static
    {

        $this->translatableRecord = $this->originalTranslatableRecord = $post;

        if ($this->translatableRecord->originalTranslation) {
            $this->originalTranslatableRecord = $this->translatableRecord->originalTranslation;
        }

        $this->translations = $this->originalTranslatableRecord->translations;

        $this->translations->push($this->originalTranslatableRecord);

        $this->missingTranslations = Language::query()
            ->whereNotIn('locale', $this->translations->pluck('language.locale')->toArray())
            ->get();

        $this->translations = $this->translations->filter(fn (Post $post): bool => $post->language->id !== $this->translatableRecord->language->id);

        $this->view('tenantforge::filament.actions.language-selector', [
            'post' => $this->translatableRecord,
            'originalPost' => $this->originalTranslatableRecord,
            'translations' => $this->translations,
            'missingTranslations' => $this->missingTranslations,
        ]);

        return $this;
    }
}
