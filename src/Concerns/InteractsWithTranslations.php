<?php

declare(strict_types=1);

namespace TenantForge\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TenantForge\Models\Language;

/**
 * @template TRelatedModel of Model
 * @template TModel of Model
 */
trait InteractsWithTranslations
{
    /**
     * @var class-string<Language>
     */
    protected static string $languageModel = Language::class;

    /**
     * @return HasMany<TRelatedModel, TModel>
     */
    public function translations(): HasMany
    {
        return $this
            ->hasMany(self::class, 'translation_id');
    }

    /**
     * @return Collection<int, TRelatedModel>
     */
    public function getTranslations(): Collection
    {
        return $this->isTranslatable() ?
            $this->translations()
                ->where('language_id', '!=', $this->language_id)
                ->get()
            : $this->getOriginalTranslation()
                ->translations()
                ->where('language_id', '!=', $this->language_id)
                ->get();

    }

    /**
     * @return BelongsTo<TRelatedModel, TModel>
     */
    public function originalTranslation(): BelongsTo
    {
        return $this->belongsTo(self::class, 'translation_id');
    }

    public function getOriginalTranslation(): self
    {
        return $this->isTranslatable() ? $this : $this->originalTranslation;
    }

    public function isTranslation(): bool
    {
        return isset($this->translation_id);
    }

    public function isTranslatable(): bool
    {
        return ! $this->isTranslation();
    }

    /**
     * @return Collection<int, Language>
     */
    public function getMissingTranslations(): mixed
    {

        $languagesIds = $this->isTranslatable()
            ? $this->getTranslations()
                ->pluck('language_id')
            : $this->getOriginalTranslation()
                ->getTranslations()
                ->pluck('language_id');

        $languagesIds = [
            ...$languagesIds,
            $this->getOriginalTranslation()
                ->language
                ->id,
        ];

        return static::$languageModel::whereNotIn('id', $languagesIds)
            ->get();

    }

    /**
     * @return BelongsTo<Language, TModel>
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(static::$languageModel, 'language_id');
    }

    public function makeTranslation(Language $language): self
    {
        // Check if the model is already translated
        $model = $this->originalTranslation ?? $this;

        $translation = $model->translations()->where('language_id', $language->id)->first();
        if ($translation) {
            return $translation;
        }

        /** @var array<string, mixed> $data */
        $data = $model->toArray();
        unset($data['id'], $data['language_id'], $data['translation_id'], $data['created_at'], $data['updated_at']);

        return $model->translations()->create([
            ...$data,
            'language_id' => $language->id,
            'translation_id' => $model->id,
        ]);

    }
}
