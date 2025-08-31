<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Closure;
use Filament\Actions\Action;
use Illuminate\View\View;

interface BuilderComponent
{
    public function render(): View;

    /**
     * @return array{Closure(Builder $component): Action}
     */
    public function getActions(Builder $component): array;
}
