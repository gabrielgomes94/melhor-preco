<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <h2 class="my-2">Custos dos produtos</h2>
            </div>

            <div class="d-flex flex-row ">
                <x-app.products.price_costs.sku-search-bar :sku="$filter['sku']" />

                <div class="my-2">
                    <x-app.costs.sync.button />
                </div>
            </div>
        </div>

        <x-app.costs.product-costs.list.table.table
            :products="$products"
        />

        <div class="d-flex justify-content-center mt-4">
            {!! $paginator->links() !!}
        </div>
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
