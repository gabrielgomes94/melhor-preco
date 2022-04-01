<div class="d-flex flex-column justify-content-around">
    <x-app.pricing.products.single-store.filter-kits :store="$store" />

    <x-bootstrap.forms.form.get
        :action="route('pricing.priceList.byStore', $store->slug())"
        :formId="$formId"
    >
        <div class="border-top my-2 py-2">
{{--            @todo: voltar a ter esse input--}}
            <x-app.pricing.products.single-store.filter-by-profit
                :store="$store"
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
