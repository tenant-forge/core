<?php

declare(strict_types=1);

use TenantForge\Settings\AppSettings;

describe('App Settings', function (): void {

    test('to array', function (): void {

        $appSettings = app(AppSettings::class);

        expect(array_keys($appSettings->toArray()))
            ->toBe([
                'name',
                'domain',
                'logo',
                'dark_logo',
                'favicon',
                'about',
                'timezone',
                'locale',

            ]);

    });

});
