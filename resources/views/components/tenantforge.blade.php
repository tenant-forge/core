    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-accent-background text-zinc-700 dark:text-zinc-300">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{ asset('vendor/tenantforge/core/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('vendor/tenantforge/core/apple-touch-icon.png') }}" />

    <title>{{ $title ?: config('tenantforge.title', 'TenantForge') }}</title>
    <meta name="title" content="{{  config('tenantforge.title', 'TenantForge') }}" />
    <meta name="description" content="{{ $description }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('/vendor/cachethq/cachet/android-chrome-512x512.png') }}" />
    <meta property="og:title" content="{{ config('cachet.title', 'Cachet') }}" />
    <meta property="og:description" content="Description" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ url('/') }}" />
    <meta property="twitter:image" content="{{ asset('/vendor/tenantforge/core/android-chrome-512x512.png') }}" />
    <meta property="twitter:title" content="{{ config('cachet.title', 'Cachet') }}" />
    <meta property="twitter:description" content="Description" />

    @vite(['resources/css/tenantforge.css', 'resources/js/tenantforge.js'], 'vendor/tenantforge/core/build')

    <style>
        [x-cloak=''],
        [x-cloak='x-cloak'],
        [x-cloak='1'] {
            display: none !important;
        }

        [x-cloak='inline-flex'] {
            display: inline-flex !important;
        }

        @media (max-width: 1023px) {
            [x-cloak='-lg'] {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            [x-cloak='lg'] {
                display: none !important;
            }
        }
    </style>

    @filamentStyles

    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}
    {{ filament()->getMonoFontHtml() }}
    {{ filament()->getSerifFontHtml() }}

    <style>
        @layer base {
            [data-theme='simple'] {
                --color-primary: #04C147;
            }
        }
    </style>

    <script>
        const loadDarkMode = () => {
            window.theme = localStorage.getItem('theme')

            if (
                window.theme === 'dark' ||
                (window.theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)')
                        .matches)
            ) {
                document.documentElement.classList.add('dark')
            }
        }

        loadDarkMode()

        document.addEventListener('livewire:navigated', loadDarkMode)
    </script>



</head>
<body class="flex min-h-screen flex-col items-stretch antialiased" data-theme="simple">

    {{ $slot }}

    @filamentScripts

    @livewire('notifications')

</body>
</html>
