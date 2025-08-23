<?php

declare(strict_types=1);

namespace TenantForge\Configure;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Livewire;
use TenantForge\Contracts\HasComponentRegistration;

use function explode;

class ConfigureLivewire implements HasComponentRegistration
{
    public static function registerComponents(string $in, string $for): void
    {
        $components = glob($in.'/*.php');

        if ($components === [] || $components === false) {
            return;
        }

        $namespaceParts = explode('\\', $for);
        /** @var string $firstNamespacePart */
        $firstNamespacePart = Arr::first($namespaceParts);
        $namespace = Str::snake($firstNamespacePart, '-');
        $namespaceParts = Arr::except($namespaceParts, 0);

        foreach ($namespaceParts as $namespacePart) {
            /** @var string $namespacePart */
            $namespace .= '.'.Str::snake($namespacePart, '-');
        }

        foreach ($components as $component) {

            /** @var string $componentName */
            $componentName = Arr::last(explode('/', $component));

            $component = Str::replace('.php', '', $componentName);
            $lowerComponent = Str::snake($component, '-');

            $componentName = "$namespace.$lowerComponent";
            $componentClass = "$for\\$component";

            Livewire::component(
                name: $componentName,
                class: $componentClass,
            );
        }

    }
}
