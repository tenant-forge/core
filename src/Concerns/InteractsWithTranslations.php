<?php

declare(strict_types=1);

namespace TenantForge\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use TenantForge\Models\Language;

use function array_key_exists;
use function sprintf;

/**
 * @template TModel of Model
 * @template TRelationModel of Model
 * @template TRelatedModel of Model
 * @template TLanguageModel of Model
 */
trait InteractsWithTranslations
{
    /**
     * @var class-string<TLanguageModel>
     */
    protected static string $languageModel = Language::class;

    /**
     * @return HasMany<TRelatedModel, TRelationModel>
     */
    public function translations(): HasMany
    {
        return $this->hasMany(self::class, 'translation_id');
    }

    /**
     * @return BelongsTo<TRelatedModel, TRelationModel>
     */
    public function originalTranslation(): BelongsTo
    {
        return $this->belongsTo(self::class, 'translation_id');
    }

    /**
     * @return BelongsTo<TLanguageModel, TRelationModel>
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(static::$languageModel, 'language_id');
    }

    /**
     * @return TModel|Model
     */
    public function makeTranslation(Language $language): mixed
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

        if (array_key_exists('slug', $data)) {
            $data['slug'] = sprintf('%s-%s-%s', $model->slug, $language->locale, Str::ulid());

        }

        return $model->translations()->create([
            ...$data,
            'language_id' => $language->id,
            'translation_id' => $model->id,
        ]);

    }
}
