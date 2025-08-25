@php use Filament\Support\Icons\Heroicon; @endphp
<div class="flex items-center">
    <button x-data x-show="!$store.theme" style="width: 20px"></button>
    <button x-cloak x-data x-show="$store.theme.dark" @click="$store.theme.lightTheme()">
        <x-filament::icon :icon="Heroicon::OutlinedSun" />
    </button>
    <button x-cloak x-data x-show="!$store.theme.dark" @click="$store.theme.darkTheme()">
        <x-filament::icon :icon="Heroicon::OutlinedMoon" />
    </button>
</div>
