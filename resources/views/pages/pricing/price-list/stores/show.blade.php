<x-layout>
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Precificação {{ $store->name }}</h2>

            <x-pricing.products.single-store.export-button :store="$store" />
        </div>

        <div class="d-flex">
            <x-pricing.products.single-store.list-table :products="$products" :store="$store"/>
        </div>
    </div>
</x-layout>
