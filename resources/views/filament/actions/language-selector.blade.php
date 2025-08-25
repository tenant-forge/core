@php use Filament\Support\Enums\IconSize;use Filament\Support\Icons\Heroicon;use Illuminate\Support\Str;use TenantForge\Filament\Central\Resources\Posts\Pages\EditPost; @endphp
<div>
    <x-filament::dropdown>
        <x-slot name="trigger">
            <x-filament::button icon="heroicon-o-language" outlined color="gray" data-test="language-selector">
                {{ Str::upper($post->language->locale) }}
                <x-filament::icon :icon="Heroicon::OutlinedChevronDown" :size="IconSize::ExtraSmall"/>
            </x-filament::button>
        </x-slot>
        <x-filament::dropdown.list>
            <x-filament::dropdown.header class="-my-2.5">
                <span class="text-xs text-zinc-400">{{ Str::upper(__('Current')) }}</span>
            </x-filament::dropdown.header>
            <x-filament::dropdown.list.item :icon="Heroicon::OutlinedCheckCircle" color="info">
                <div class="flex w-full justify-between">
                    <span>{{ $post->language->name }}</span>
                    <x-filament::badge color="info" outlined>
                        {{ Str::title(__('Current')) }}
                    </x-filament::badge>
                </div>
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
        @if($translations->count() > 0)
            <x-filament::dropdown.list>
                <x-filament::dropdown.header class="-my-2.5">
                    <span class="text-xs text-zinc-400">{{ Str::upper(__('Translations')) }}</span>
                </x-filament::dropdown.header>
                @foreach($translations as $translation)
                    <x-filament::dropdown.list.item
                        :icon="Heroicon::OutlinedPencil"
                        :href="EditPost::getUrl(['record' => $translation->id, 'type' => $translation->type->slug])"
                        tag="a"
                        color="success"
                    >
                        {{ $translation->language->name  }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        @endif

        @if($missingTranslations->count() > 0)
            <x-filament::dropdown.list>
                <x-filament::dropdown.header class="-my-2.5">
                    <span class="text-xs text-zinc-400">{{ Str::upper(__('Missing')) }}</span>
                </x-filament::dropdown.header>
                @foreach($missingTranslations as $language)
                    <x-filament::dropdown.list.item
                        :icon="Heroicon::OutlinedPlusCircle"
                        :href="EditPost::getUrl(['record' => $post->id, 'type' => $post->type->slug])"
                        tag="a"
                        color="gray"
                    >
                        {{ $language->name  }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        @endif


    </x-filament::dropdown>
</div>
