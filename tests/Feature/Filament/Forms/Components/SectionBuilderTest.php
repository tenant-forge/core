<?php

declare(strict_types=1);

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use TenantForge\Filament\Forms\Components\Builder\Builder;
use TenantForge\Filament\Forms\Components\Builder\SectionBuilder;

describe('section builder test', function (): void {

    it('returns a array of actions',
        /**
         * @throws Exception
         */
        function (): void {

            $component = Builder::make('custom_fields');

            // Properly initialize the component with a mock container
            $component->container(
                Schema::make()
            );

            $sectionBuilder = SectionBuilder::make(
                field: $component,
            );

            /** @var Action $action */
            $action = collect($sectionBuilder->getActions($component))
                ->first();

            expect($action)
                ->toBeInstanceOf(Closure::class)
                ->and($action($component)->getName())
                ->toBe($sectionBuilder->getAddSectionActionName())
                ->and($action($component))
                ->toBeInstanceOf(Action::class)
                ->and($component->getActions())
                ->toBeArray()
                ->and($component->getActions())
                ->toHaveKeys([
                    $sectionBuilder->getAddSectionActionName(),
                ]);

        });

    test('we can create a section builder for testing',
        /**
         * @throws Exception
         */
        function (): void {

            $sectionBuilder = SectionBuilder::make(
                field: Builder::make('custom_fields'),
            );

            expect($sectionBuilder)
                ->toBeInstanceOf(SectionBuilder::class);

        });

});
