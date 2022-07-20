<x-bootstrap.card.basic.card class="p-1">
    <x-bootstrap.card.basic.card-body>
        <div class="d-inline-flex flex-row justify-content-between">
            <h3>Preços {{ $currentMarketplace['name'] }}</h3>

            <div class="d-inline-flex flex-row">
                <x-app.pricing.price-list.filters.buttons :marketplaceSlug="$currentMarketplace['slug']" />

                <span class="m-2"></span>

                <x-app.pricing.price-list.dropdowns.options :marketplaceSlug="$currentMarketplace['slug']" />
            </div>
        </div>

        <x-app.pricing.price-list.products.store-list.table
            :products="$products"
            :marketplace="$currentMarketplace"
        />
    </x-bootstrap.card.basic.card-body>

    <div class="my-4">
        <x-bootstrap.paginator.paginator-links :paginator="$paginator" />
    </div>
</x-bootstrap.card.basic.card>
