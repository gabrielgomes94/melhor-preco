<x-layout>
    <x-slot name="header">
        Produtos mais vendidos
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>
    </div>

    <x-sales.sales-list.card>
        <div class="mb-2">
            <x-sales.sales-list.filter.form />


            <x-sales.reports.most-selled-products :products="$products" />
        </div>
    </x-sales.sales-list.card>
</x-layout>
