<x-layout>
    <x-slot name="navbar">
        <x-costs.navbar />
    </x-slot>

    <x-slot name="header">
        Atualizar custos dos produtos
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>

        <div class="row">
            <div class="d-flex justify-content-end">
                <x-products.price_costs.sku-search-bar :sku="$sku" />
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <x-template.card.card>
                    <x-products.price_costs.table :products="$products" />

                    <div class="d-flex justify-content-center mt-4">
                        {!! $paginator->links() !!}
                    </div>
                </x-template.card.card>
            </div>
        </div>
    </div>
</x-layout>
