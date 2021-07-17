<x-layout>
    <div class="container">
        <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>

        <div class="d-flex justify-content-between">
            <h2>Precificação {{ $store->name }}</h2>

            <x-pricing.products.single-store.export-button :store="$store" />
        </div>

        <div class="d-flex">
            <x-pricing.price-list.products.store-list.table :products="$products" :store="$store"/>
        </div>

        <x-utils.paginator-links :paginator="$paginator" />
    </div>
</x-layout>
