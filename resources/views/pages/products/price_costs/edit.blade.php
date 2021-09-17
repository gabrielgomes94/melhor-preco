<x-layout>
    <x-slot name="header">
        Atualizar custos dos produtos
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>

        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <x-products.price_costs.sku-search-bar :sku="$sku" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <x-products.price_costs.table :products="$products" />

                <div class="d-flex justify-content-center">
                    {!! $paginator->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>
