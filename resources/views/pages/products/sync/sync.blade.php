<x-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sincronização de dados de produtos') }}
        </h1>
    </x-slot>

    <div class="row">
        <div class="col-6">
            <x-bootstrap.card.basic.card class="h-100">
                <x-app.products.sync.sync-products-card />
            </x-bootstrap.card.basic.card>
        </div>

        <div class="col-6">
        </div>
    </div>
</x-layout>
