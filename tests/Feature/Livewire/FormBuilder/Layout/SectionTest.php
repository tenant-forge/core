<?php

declare(strict_types=1);

use Livewire\Livewire;
use TenantForge\Livewire\FormBuilder\Layout\Section;

describe('form section', function (): void {

    it('should render the section', function (): void {

        Livewire::test(Section::class)
            ->assertSee('Section');

    });

});
