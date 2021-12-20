<x-layout>
    <x-slot name="header">
        Produtos mais vendidos
    </x-slot>

    <div class="container">
        <div class="row">
            <x-utils.alert-messages />
        </div>
    </div>

    <x-app.sales.sales-list.card>
        <div class="mb-2">
            <x-app.sales.sales-list.filter.form :route="route('sales.reports.mostSelledProducts')" />

            <x-app.sales.reports.most-selled-products :products="$products" />
        </div>
    </x-app.sales.sales-list.card>
</x-layout>
