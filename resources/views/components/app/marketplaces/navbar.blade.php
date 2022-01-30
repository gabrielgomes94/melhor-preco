<x-bootstrap.navbar.navbar>
    <x-bootstrap.navbar.item
        :route="route('marketplaces.list')"
        label="Marketplaces integrados"
        id="nav-marketplaces-list"
    />

    <x-bootstrap.navbar.item
        :route="route('marketplaces.create')"
        label="Adicionar novo marketplace"
        id="nav-marketplaces-create"
    />
</x-bootstrap.navbar.navbar>
