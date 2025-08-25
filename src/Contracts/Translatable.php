<?php

declare(strict_types=1);

namespace TenantForge\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TenantForge\Models\Language;

/**
 * @template TModel of Model
 * @template TRelationModel of Model
 * @template TRelatedModel of Model
 * @template TLanguageModel of Model
 */
interface Translatable
{
    /**
     * @return HasMany<TRelatedModel, TRelationModel>
     */
    public function translations(): HasMany;

    /**
     * @return BelongsTo<TRelatedModel, TRelationModel>
     */
    public function originalTranslation(): BelongsTo;

    /**
     * @return BelongsTo<TLanguageModel, TRelationModel>
     */
    public function language(): BelongsTo;

    /**
     * @return TModel|Model
     */
    public function makeTranslation(Language $language): mixed;
}
