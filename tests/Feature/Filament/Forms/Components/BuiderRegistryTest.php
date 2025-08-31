<?php

declare(strict_types=1);

use Illuminate\Contracts\Container\BindingResolutionException;
use TenantForge\Filament\Forms\Components\Builder\Builder;
use TenantForge\Filament\Forms\Components\Builder\BuilderRegistry;
use TenantForge\Filament\Forms\Components\Builder\SectionBuilder;
use TenantForge\Filament\Forms\Components\Builder\TextInputBuilder;

beforeEach(/**
 * @throws BindingResolutionException
 */ function () {
    $this->builderRegistry = app()->make(BuilderRegistry::class);

});

describe('builder registry test', function () {

    test('it can access component actions',
        /**
         * @throws BindingResolutionException
         * @throws Exception
         */
        function (): void {

            $builder = Builder::make('test');
            $sectionComponent = $this->builderRegistry->getBuilderComponent(
                $builder,
                SectionBuilder::$type
            );

            $actions = $sectionComponent->getActions($builder);

            expect($actions[0])
                ->toBeInstanceOf(Closure::class);

        });

    test('it returns a list of register components', function (): void {

        $components = $this->builderRegistry->components();

        expect($components)
            ->toBe([
                SectionBuilder::$type => SectionBuilder::class,
                TextInputBuilder::$type => TextInputBuilder::class,
            ]);

    });

    test('is registered on the service provider as a singleton',
        /** @throws BindingResolutionException */
        function (): void {

            // Arrange
            $registry1 = app()->make(BuilderRegistry::class);

            // Act
            $registry2 = app()->make(BuilderRegistry::class);

            // Assert
            expect($registry1)
                ->toBe($registry2);

        });

});
