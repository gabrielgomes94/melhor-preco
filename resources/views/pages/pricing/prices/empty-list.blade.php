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
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex flex-row">
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
            <x-app.pricing.price-list.card.empty-card
                :currentMarketplace="$currentMarketplace"
            >
            </x-app.pricing.price-list.card.empty-card>
        </div>
    </div>
</x-layout>
