<?php

declare(strict_types=1);

use Livewire\Livewire;
use TenantForge\Livewire\FormBuilder\Fields\TextInput;

describe('Field TextInput', function (): void {

    it('should render the text input', function (): void {

        Livewire::test(TextInput::class)
            ->assertSee('Text Input');

    });

});
