<?php

declare(strict_types=1);

namespace TenantForge\Filament\Forms\Components\Builder;

use Exception;
use Filament\Forms\Components\Field;

class Component
{
    public static string $type = 'base';

    public static bool $hasChildren = false;

    /**
     * @param  array{component: string, name: string, schemaPath: string, configuration: array<string, mixed>}|null  $state
     */
    public function __construct(
        public Field $field,
        public ?string $name = null,
        public ?array $state = null,
        public ?BuilderComponent $parentComponent = null,
    ) {}

    /**
     * @param  array{component: string, name: string, schemaPath: string, configuration: array<string, mixed>}|null  $state
     */
    public static function make(Field $field, ?string $name = null, ?string $schemaPath = null, ?array $state = null, ?BuilderComponent $parentComponent = null): self
    {
        return new self(
            field: $field,
            name: $name,
            state: $state,
            parentComponent: $parentComponent,
        );

    }

    /**
     * @throws Exception
     */
    public function getType(): string
    {
        $type = static::$type;
        if ($type === 'base') {
            throw new Exception('Component type not set.');
        }

        return $type;
    }

    public function hasChildren(): bool
    {
        return static::$hasChildren;
    }
}
