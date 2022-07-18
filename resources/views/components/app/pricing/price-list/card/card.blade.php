<x-bootstrap.card.basic.card class="p-1">
    <x-bootstrap.card.basic.card-body>
        <div class="d-inline-flex flex-row justify-content-between">
            <h3>Preços {{ $currentMarketplace['name'] }}</h3>

            <x-app.pricing.price-list.filters.buttons :marketplaceSlug="$currentMarketplace['slug']" />
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
