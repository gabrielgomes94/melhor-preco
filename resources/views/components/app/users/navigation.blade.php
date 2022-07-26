<x-bootstrap.navigation.nav-tabs>
    <x-bootstrap.navigation.nav-item
        id="nav-settings-integrations-tab"
        label="Integrações"
        selected="{{ $selectedNav == 'integrations' }}"
        :route="route('users.settings.integrations')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-settings-marketplaces-tab"
        label="Marketplaces"
        selected="{{ $selectedNav == 'marketplaces' }}"
        :route="route('marketplaces.list')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-settings-taxes-tab"
        label="Impostos"
        selected="{{ $selectedNav == 'taxes' }}"
        :route="route('users.settings.taxes')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-settings-profile-tab"
        label="Informações da Conta"
        selected="{{ $selectedNav == 'profile' }}"
        :route="route('users.settings.profile')"
    />
</x-bootstrap.navigation.nav-tabs>
