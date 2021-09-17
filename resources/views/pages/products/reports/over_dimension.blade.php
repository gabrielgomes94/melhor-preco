<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Produtos que Excedem Dimensões') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-12 mb-4">
            <x-utils.alert-messages />

            <x-template.card.card>
                <x-products.reports.over-dimensions-table :products="$overDimensionProducts"/>
            </x-template.card.card>
        </div>
    </div>
</x-layout>
