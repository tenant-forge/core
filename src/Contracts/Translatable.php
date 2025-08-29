<?php

declare(strict_types=1);

namespace TenantForge\Contracts;

use TenantForge\Models\Language;

interface Translatable
{
    public function getTranslations(): mixed;

    public function getOriginalTranslation(): self;

    public function isTranslation(): bool;

    public function isTranslatable(): bool;

    public function getMissingTranslations(): mixed;

    public function makeTranslation(Language $language): self;
}
