<x-tenantforge::auth
    app-name="{{ $appName }}"
    heading="{{ __('tenantforge::tenants.create_your_organization') }}"
    subheading="{{ __('tenantforge::tenants.create_your_organization_subheading') }}"
>

    {{ $this->content }}

</x-tenantforge::auth>
