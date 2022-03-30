<x-layout>
    <x-slot name="header">
        Atualizar custos dos produtos
    </x-slot>

    <div class="container">
        <div class="row">
            <x-bootstrap.alert-messages.alert-messages />
        </div>

        <div class="row">
            <div class="d-flex justify-content-end">
                <x-app.products.price_costs.sku-search-bar :sku="$sku" />
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-12">
                <x-bootstrap.card.basic.card>
                    <x-app.products.price_costs.table :products="$products" />

                    <div class="d-flex justify-content-center mt-4">
                        {!! $paginator->links() !!}
                    </div>
                </x-bootstrap.card.basic.card>
            </div>
        </div>
    </div>
</x-layout>
