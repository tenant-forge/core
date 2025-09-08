<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Filament\Forms\Components\Field;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;

class BuilderRegistry
{
    /**
     * @param  array{component: string, name: string, schemaPath: string, configuration: array<string, mixed>}|null  $state
     *                                                                                                                       /
     * @throws BindingResolutionException
     */
    public static function getBuilderComponent(Field $field, string $type, ?array $state = null): BuilderComponent
    {

        $components = static::components();

        if (! isset($components[$type])) {
            throw new InvalidArgumentException("Builder component [{$type}] not found.");
        }
        /** @var BuilderComponent $component */
        $component = app()->make(static::components()[$type], [
            'field' => $field,
            'state' => $state,
        ]);

        return $component;

    }

    /**
     * @return array<string, class-string<BuilderComponent>>
     */
    public static function components(): array
    {
        return [
            SectionBuilder::$type => SectionBuilder::class,
            TextInputBuilder::$type => TextInputBuilder::class,
        ];
    }
}
