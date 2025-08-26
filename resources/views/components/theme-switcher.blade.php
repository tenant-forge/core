@php use Filament\Support\Icons\Heroicon; @endphp
<div x-data="{
        theme: window.theme,
        lightTheme() {
            window.theme = 'light'
            localStorage.theme = 'light'
            document.documentElement.classList.remove('dark')
            this.theme = 'light'
        },
        darkTheme() {
            window.theme = 'dark'
            localStorage.theme = 'dark'
            document.documentElement.classList.add('dark')
            this.theme = 'dark'
        }

    }"
     class="flex items-center justify-center min-w-[1.5rem]">
    <button x-data
            x-cloak
            x-show="theme === 'dark'"
            @click="lightTheme()"
            class="transition-all opacity-100 duration-550 starting:opacity-0"
    >
        <x-filament::icon :icon="Heroicon::OutlinedSun" />
    </button>
    <button x-data
            x-cloak
            x-show="theme === 'light'"
            @click="darkTheme()"
            class="transition-all opacity-100 duration-550 starting:opacity-0"
    >
        <x-filament::icon :icon="Heroicon::OutlinedMoon" />
    </button>
</div>
