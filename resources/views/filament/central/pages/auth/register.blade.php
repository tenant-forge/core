<x-tenantforge::auth
    app-name="{{ $appName }}"
    heading="Welcome to {{ $appName }}"
    subheading="Sign up to get started"
>

    {{ $this->content }}

    <div class="mt-8 text-sm text-zinc-500 dark:text-zinc-600">
        {{ __('tenantforge::auth.already_have_an_account') }}
        {{ $this->alreadyHaveAnAccountAction() }}
    </div>

</x-tenantforge::auth>
