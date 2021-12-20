<div class="d-flex flex-column justify-content-around">
    <x-app.pricing.products.single-store.filter-kits :store="$store" />

    <div class="border-top my-2 py-2">
        <x-app.pricing.products.single-store.filter-by-profit
            :store="$store"
            :minimumProfit="$minimumProfit"
            :maximumProfit="$maximumProfit"
            :sku="$sku"
            :formId="$formId"
        />
    </div>
</div>
