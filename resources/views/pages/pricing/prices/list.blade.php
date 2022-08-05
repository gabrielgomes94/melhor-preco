<x-layout>
    <x-app.pricing.navigation :activeNavPrices="true"/>

    <x-slot name="modals">
        <x-bootstrap.modals.modal
            id="filterModal"
            title="Filtrar produtos"
            actionLabel="Filtrar"
            formId="filter-products-form"
        >
            <x-app.pricing.price-list.filters.modal.content
                :filter="$filter"
                :currentMarketplace="$currentMarketplace"
                :marketplaceSlug="$currentMarketplace['slug']"
                formId="filter-products-form"
            />
        </x-bootstrap.modals.modal>

        <x-app.pricing.mass-calculation.modal.modal
            :marketplaceSlug="$currentMarketplace['slug']"
            :filter="$filter"
        />
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex flex-row justify-content-center">
                    <x-app.pricing.price-list.dropdowns.marketplaces
                        :marketplaces="$marketplaces"
                        :currentMarketplace="$currentMarketplace"
                    />
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
            />
        </div>
    </div>
</x-layout>
