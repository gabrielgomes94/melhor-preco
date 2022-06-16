<x-app.base.navbar.navbar>
    <x-app.base.navbar.navbar-item
        :link="route('marketplaces.list')"
        label="Marketplaces"
    />

    <x-app.base.navbar.navbar-item
        :link="route('users.settings.taxes')"
        label="Impostos"
    />

    <x-app.base.navbar.navbar-item
        :link="route('users.settings.integrations')"
        label="Integrações"
    />

    <x-app.base.navbar.navbar-item
        :link="route('users.settings.integrations')"
        label="Informações da Conta"
    />
</x-app.base.navbar.navbar>
