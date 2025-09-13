@php use Illuminate\Database\Eloquent\Builder;use Illuminate\Support\Str;use TenantForge\Filament\Forms\Components\Builder\BuilderRegistry;

$deleteAction = $getAction($getDeleteActionName());
$addComponentAction = $getAction($getAddSectionActionName());

@endphp
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field">
    <x-filament::section>
        <div class="flex flex-col gap-4">

            <div class="flex flex-col gap-4 mb-4">
                @if($field->getState())

                    @foreach($field->getState() as $key => $component)
                        {{ $renderComponent($component['component'], [
                                'name' => $component['name'],
                                'schemaPath' => 'somePath',
                                'configuration' => $component['configuration'],
                            ])
                        }}
                        <div
                            class="border border-dashed border-zinc-200 dark:border-zinc-700 p-4 rounded flex items-center justify-between">
                            <span class="font-semibold">{{ Str::title($component['name']) }}</span>
                            <div>
                                {{ $deleteAction(['item' => $key]) }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        {{ $addComponentAction([]) }}

    </x-filament::section>
</x-dynamic-component>
