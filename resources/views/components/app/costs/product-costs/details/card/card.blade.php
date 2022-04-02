<x-bootstrap.card.basic.card>
    <x-bootstrap.card.basic.card-body>
{{--        <div class="d-flex justify-content-between my-2">--}}
{{--            <div class="d-flex align-items-end">--}}
{{--                <h2 class="m-0">Custos dos produtos</h2>--}}
{{--            </div>--}}

{{--            <x-app.products.price_costs.sku-search-bar :sku="$sku" />--}}
{{--        </div>--}}

        <x-app.costs.product-costs.details.table.table
            :costs="$costs"
        />

{{--        <div class="d-flex justify-content-center mt-4">--}}
{{--            {!! $paginator->links() !!}--}}
{{--        </div>--}}
    </x-bootstrap.card.basic.card-body>
</x-bootstrap.card.basic.card>
