<header class="py-4">
    <nav class="max-w-7xl mx-auto px-4 flex items-center justify-between">
        <div>
            <a href="{{ route('tenantforge.home') }}" class="text-2xl font-bold">
                @if($logo && $darkLogo)
                    <img src="{{ asset($logo) }}" alt="{{ $title }}" class="h-8 dark:hidden" />
                    <img src="{{ asset($darkLogo) }}" alt="{{ $title }}" class="h-8 hidden dark:block" />
                @else
                    {{ config('app.name', 'TenantForge') }}
                @endif
            </a>
        </div>
        <ul class="flex gap-7">
            <li>
                Features
            </li>
            <li>
                How it works
            </li>
            <li>
                Pricing
            </li>
            <li>
                FAQ
            </li>
            <li>
                Blog
            </li>
            <li class="text-secondary-600 font-medium">
                Roadmap
            </li>
        </ul>
        <ul class="flex items-center gap-4">
            <li>
                <x-tenantforge::theme-switcher />
            </li>
            <li>
                <a href="{{ route('tenantforge.sign-in') }}">Login</a>
            </li>
            <li>
                <a
                    href="{{ route('tenantforge.sign-up') }}"
                    class="text-white py-2 px-4 bg-primary dark:bg-primary-600 rounded-md hover:bg-green-600 dark:hover:bg-green-700 transition-all duration-200">
                    Start Free Trial
                </a>
            </li>
        </ul>
    </nav>
</header>
