@php

$addComponentAction = $component->getAction('add-component');


$fields = [
    'Text',
    'Assets',
    'Stacks',
    'Slug',
    'Boolean',
    'Number',
    'Currency'
];


@endphp


<div>

    <div class="flex flex-col space-y-4">

        @foreach($fieldTypes as $type)
            @php
                $name = $type($component)->getName();
                $action = $component->getAction($name);


            @endphp
            {{ $action([$component]) }}
        @endforeach

        @foreach($fields as $field)
            <div class="px-4 py-3 border border-dashed border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded">
                <span class="text-sm font-semibold">{{ $field }}</span>
            </div>
        @endforeach
    </div>

</div>
