<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use TenantForge\Actions\Languages\SetDefaultLanguageAction;
use TenantForge\Models\Language;

describe('Set default language', function (): void {

    test('only one language is default', function (): void {
        /** @var Collection<int, Language> $languages */
        $languages = Language::factory()
            ->count(5)
            ->create([
                'is_default' => false,
            ]);

        /** @var Language $language */
        $language = Language::factory()
            ->create([
                'is_default' => true,
            ])
            ->fresh();

        SetDefaultLanguageAction::handle(
            locale: $languages->first()->locale ?? '',
        );

        expect($language->fresh()?->is_default)
            ->toBeFalse();

    });

});
