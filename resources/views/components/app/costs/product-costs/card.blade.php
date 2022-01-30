<x-template.card.card>
    <x-template.card.card-body>
        <div class="d-flex justify-content-between my-2">
            <div class="d-flex align-items-end">
                <h2 class="m-0">Custos dos produtos</h2>
            </div>

            <x-app.products.price_costs.sku-search-bar :sku="$sku" />
        </div>

        <x-app.costs.product-costs.table.table :products="$products" />

        <div class="d-flex justify-content-center mt-4">
            {!! $paginator->links() !!}
        </div>
    </x-template.card.card-body>
</x-template.card.card>
