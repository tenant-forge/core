<?php

declare(strict_types=1);

use TenantForge\Models\Language;

describe('Language Model', function (): void {

    test('to array', function (): void {

        // Arrange
        /** @var Language $language */
        $language = Language::factory()
            ->create()
            ->fresh();

        // Assert
        expect(array_keys($language->toArray()))
            ->toBe([
                'id',
                'locale',
                'name',
                'default',
                'active',
                'created_at',
                'updated_at',
            ]);

    });

});
