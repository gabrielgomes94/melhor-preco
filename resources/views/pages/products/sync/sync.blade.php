<x-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sincronização de dados de produtos') }}
        </h1>
    </x-slot>

    <div class="row">
        <div class="col-6">
            <x-template.card.card class="h-100">
                <x-products.sync.sync-products-card />
            </x-template.card.card>
        </div>

        <div class="col-6">
            <x-template.card.card>
                <x-products.sync.upload-spreadsheet-card />
            </x-template.card.card>
        </div>
    </div>
</x-layout>
