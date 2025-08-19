<x-tenantforge::auth
    app-name="{{ $appName }}"
    heading="Welcome to {{ $appName }}"
    subheading="{{ __('tenantforge::auth.sign_in_message') }}"
>

    {{ $this->content }}

    <div class="mt-8 text-sm text-zinc-500 dark:text-zinc-600">
        {{ __('tenantforge::auth.dont_have_an_account') }}
        {{ $this->dontHaveAnAccountAction() }}
    </div>

</x-tenantforge::auth>
