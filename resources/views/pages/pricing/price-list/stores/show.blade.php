<x-layout>
    <x-slot name="navbar">
        <x-pricing.price-list.navbar :selected="$store->slug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-utils.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <x-slot name="modals">
        <x-template.modals.modal
            id="filterModal"
            title="Filtrar produtos"
            actionLabel="Filtrar"
            formId="filter-products-form"
        >
            <x-pricing.price-list.filters.filter
                :store="$store"
                :minimumProfit="$minimumProfit"
                :maximumProfit="$maximumProfit"
                :sku="$sku"
                formId="filter-products-form"
            />
        </x-template.modals.modal>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex flex-column justify-content-center">
                    <x-pricing.price-list.history-link :store="$store" />
                </div>

                <div class="d-flex flex-column">
                    <x-pricing.price-list.filters.buttons :store="$store" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <x-template.card.card class="p-1">
                <x-pricing.price-list.products.store-list.table :products="$products" :store="$store"/>

                <div class="my-4">
                    <x-utils.paginator-links :paginator="$paginator" />
                </div>
            </x-template.card.card>
        </div>
    </div>
</x-layout>
