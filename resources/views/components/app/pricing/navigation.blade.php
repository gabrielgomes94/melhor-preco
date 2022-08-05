<x-bootstrap.navigation.nav-tabs>
    <x-bootstrap.navigation.nav-item
        id="nav-prices-list"
        label="Preços"
        class="{{ ($activeNavPrices ?? null) ? 'active' : '' }}"
        :route="route('pricing.priceList.byStore')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-product-costs"
        label="Custos dos produtos"
        class="{{ ($activeNavCosts ?? null) ? 'active' : '' }}"
        :route="route('costs.product.list')"
    />

    <x-bootstrap.navigation.nav-item
        id="nav-costs-purchase-invoices"
        label="Notas fiscais de entrada"
        class="{{ ($activeNavPurchaseInvoices ?? null) ? 'active' : '' }}"
        :route="route('costs.listPurchaseInvoices')"
    />
</x-bootstrap.navigation.nav-tabs>
