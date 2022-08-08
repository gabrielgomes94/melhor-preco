<x-bootstrap.navigation.nav-tabs>
    <x-bootstrap.navigation.nav-item
        id="nav-settings-integrations-tab"
        label="Integrações"
        class="{{ $selectedNav == 'integrations' ? 'active' : '' }}"
        :route="route('users.settings.integrations')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-settings-marketplaces-tab"
        label="Marketplaces"
        class="{{ $selectedNav == 'marketplaces' ? 'active' : '' }}"
        :route="route('marketplaces.list')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-settings-taxes-tab"
        label="Impostos"
        class="{{ $selectedNav == 'taxes' ? 'active' : '' }}"
        :route="route('users.settings.taxes')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-settings-profile-tab"
        label="Informações da Conta"
        class="{{ $selectedNav == 'profile' ? 'active' : '' }}"
        :route="route('users.settings.profile')"
    />
</x-bootstrap.navigation.nav-tabs>
