<x-app.base.navbar.navbar>
    <x-app.base.navbar.navbar-item
        :link="route('sales.list')"
        label="Lista de vendas"
    />

    <x-app.base.navbar.navbar-item
        :link="route('sales.reports.mostSelledProducts')"
        label="Produtos mais vendidos"
    />
</x-app.base.navbar.navbar>
