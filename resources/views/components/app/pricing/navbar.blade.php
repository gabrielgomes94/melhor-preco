<x-app.base.navbar.navbar>
    <x-app.base.navbar.navbar-item
        :link="route('pricing.priceList.byStore', 'magalu')"
        label="Calculadora de Preços"
    />

    <x-app.base.navbar.navbar-item
        :link="route('promotions.index')"
        label="Promoções"
    />

    <x-app.base.navbar.navbar-item
        :link="route('costs.product.list')"
        label="Custos dos Produtos"
    />

    <x-app.base.navbar.navbar-item
        :link="route('costs.listPurchaseInvoices')"
        label="Notas Fiscais de Entrada"
    />
</x-app.base.navbar.navbar>
