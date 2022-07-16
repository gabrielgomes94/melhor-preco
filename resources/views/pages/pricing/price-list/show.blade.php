<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.navbar />
    </x-slot>

    <x-slot name="breadcrumb">
        <x-bootstrap.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <x-slot name="modals">
        <x-bootstrap.modals.modal
            id="filterModal"
            title="Filtrar produtos"
            actionLabel="Filtrar"
            formId="filter-products-form"
        >
            <x-app.pricing.price-list.filters.modal.content
                :store="$store"
                :filter="$filter"
                :currentMarketplace="$currentMarketplace"
                formId="filter-products-form"
            />
        </x-bootstrap.modals.modal>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex flex-row justify-content-center">
                    <x-app.pricing.price-list.dropdowns.menu />

                    <div class="mx-1"></div>

                    <x-app.pricing.price-list.dropdowns.marketplaces
                        :marketplaces="$marketplaces"
                        :currentMarketplace="$currentMarketplace"
                    />
                </div>

                <div class="d-inline-flex flex-row">
                    <x-app.pricing.price-list.filters.buttons :store="$store" />

                    <span class="m-2"></span>

                    <x-app.pricing.price-list.sync.buttons :store="$store->slug()" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <x-app.pricing.price-list.card.card
                :paginator="$paginator"
                :products="$products"
                :currentMarketplace="$currentMarketplace"
                :store="$store"
            />
        </div>
    </div>
</x-layout>
