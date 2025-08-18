<x-tenantforge::auth
    app-name="{{ $appName }}"
    heading="Welcome to {{ $appName }}"
    subheading="Sign up to get started"
>

    {{ $this->content }}

</x-tenantforge::auth>
