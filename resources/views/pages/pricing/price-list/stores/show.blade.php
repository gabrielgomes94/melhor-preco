<x-layout>
    <x-slot name="navbar">
        <x-app.pricing.price-list.navbar :selected="$store->slug()"/>
    </x-slot>

    <x-slot name="breadcrumb">
        <x-template.breadcrumb.breadcrumb :breadcrumb="$breadcrumb"/>
    </x-slot>

    <x-slot name="modals">
        <x-template.modals.modal
            id="filterModal"
            title="Filtrar produtos"
            actionLabel="Filtrar"
            formId="filter-products-form"
        >
            <x-app.pricing.price-list.filters.modal.content
                :store="$store"
                :filter="$filter"
                formId="filter-products-form"
            />
        </x-template.modals.modal>


        <x-app.pricing.price-list.mass-calculation.modal.modal
            :store="$store"
            :filter="$filter ?? []"
            :massCalculation="$massCalculation"
        />
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex flex-column justify-content-center">
                    <x-app.pricing.price-list.history-link :store="$store" />
                </div>

                <div class="d-inline-flex flex-row">
                    <x-app.pricing.price-list.filters.buttons :store="$store" />
                    <span class="m-2"></span>
                    <x-app.pricing.price-list.mass-calculation.buttons :store="$store" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <x-template.card.card class="p-1">
                <x-app.pricing.price-list.products.store-list.table
                    :products="$products"
                    :store="$store"
                />

                <div class="my-4">
                    <x-template.paginator.paginator-links :paginator="$paginator" />
                </div>
            </x-template.card.card>
        </div>
    </div>
</x-layout>
