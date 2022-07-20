<div class="d-flex flex-column justify-content-around">
    <x-app.pricing.price-list.filters.forms.filter-links
        :marketplaceSlug="$marketplaceSlug"
    />

    <x-bootstrap.forms.form.get
        :action="route('pricing.priceList.byStore', $marketplaceSlug)"
        :formId="$formId"
    >
        <div class="border-top my-2 py-2">
            <x-app.pricing.price-list.filters.forms.filter-form
                :minimumProfit="$filter['minimumProfit'] ?? null"
                :maximumProfit="$filter['maximumProfit'] ?? null"
                :sku="$filter['sku'] ?? null"
                :filter="$filter"
                :formId="$formId"
            />
        </div>
    </x-bootstrap.forms.form.get>
</div>
