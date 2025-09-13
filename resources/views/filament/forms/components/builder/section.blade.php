@php
    $openComponentsDialogAction = $field->getAction('add-component');

@endphp
<div class="flex flex-col items-center">
    <div class="flex flex-col w-full border border-dashed border-gray-400 p-4 rounded">
        <div>{{ $name }}</div>
    </div>
    @if($hasChildren)
        <div class="mt-2">
            {{ $openComponentsDialogAction([
                'parent' => $schemaPath,
                'name' => $name,
                'schemaPath' => $schemaPath,
                'configuration' => $configuration,
            ]) }}
        </div>
    @endif
</div>
