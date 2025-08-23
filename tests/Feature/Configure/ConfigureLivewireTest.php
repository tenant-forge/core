<?php

declare(strict_types=1);

use Livewire\Mechanisms\ComponentRegistry;
use TenantForge\Configure\ConfigureLivewire;
use TenantForge\Tests\Fixtures\Livewire\Button;

describe('Configure Livewire', function (): void {

    test('it registers livewire components', function (): void {

        // Arrange

        /** @var ComponentRegistry $componentRegistry */
        $componentRegistry = app(ComponentRegistry::class);

        // Act
        ConfigureLivewire::registerComponents(
            in: __DIR__.'/../../Fixtures/Livewire',
            for: 'TenantForge\Tests\Fixtures\Livewire'
        );

        // Assert
        expect($componentRegistry->getClass('tenant-forge.tests.fixtures.livewire.button'))
            ->toBe(Button::class);

    });

});
