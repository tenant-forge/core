<?php

declare(strict_types=1);

use Livewire\Livewire;
use TenantForge\Livewire\FormBuilder\Builder;

describe('Builder', function (): void {

    it('should render the builder', function (): void {
        Livewire::test(Builder::class)
            ->assertSee('Builder');

    });

});
