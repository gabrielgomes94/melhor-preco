<x-bootstrap.modals.modal
    id="filterModal"
    title="Filtrar produtos"
    actionLabel="Filtrar"
    formId="filter-products-form"
>
    <x-app.pricing.price-list.filters.modal.content
        :minimumProfit="$filter['minimumProfit']"
        :maximumProfit="$filter['maximumProfit']"
        :sku="$filter['sku']"
        :categories="$filter['categories']"
        formId="filter-products-form"
    />
</x-bootstrap.modals.modal>
