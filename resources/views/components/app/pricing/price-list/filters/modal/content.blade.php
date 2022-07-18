<div class="d-flex flex-column justify-content-around">
    <x-app.pricing.price-list.filters.forms.filter-kits :marketplaceSlug="$marketplaceSlug" />

    <x-bootstrap.forms.form.get
        :action="route('pricing.priceList.byStore', $marketplaceSlug)"
        :formId="$formId"
    >
        <div class="border-top my-2 py-2">
            <x-app.pricing.price-list.filters.forms.filter-by-profit
                :minimumProfit="$filter['minimumProfit'] ?? null"
                :maximumProfit="$filter['maximumProfit'] ?? null"
                :sku="$filter['sku'] ?? null"
                :formId="$formId"
            />
        </div>

        <div class="mb-4">
            <x-app.products.filters.category :filter="$filter" />
        </div>
    </x-bootstrap.forms.form.get>
</div>
