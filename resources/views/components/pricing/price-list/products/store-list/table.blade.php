<table class="table table-bordered table-hover">
    <thead>
        <x-pricing.price-list.products.store-list.table.header />
    </thead>

    <tbody>
        @foreach($products as $product)
            <x-pricing.price-list.products.store-list.table.product-row
                :product="$product"
                :store="$store->slug"
            />

            @if ($product->hasVariations())
                <x-pricing.price-list.products.store-list.table.variations-row
                    :variations="$product->variations()"
                    :store="$store->slug"
                />
            @endif
        @endforeach
    </tbody>
</table>