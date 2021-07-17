<table class="table table-bordered table-hover">
    <thead>
        <x-pricing.products.single-store.table.header />
    </thead>

    <tbody>
        @foreach($products as $product)
            <x-pricing.products.single-store.table.product-row
                :product="$product"
                :store="$store->slug"
            />

            @if ($product->hasVariations())
                <x-pricing.products.single-store.table.variations-row
                    :variations="$product->variations()"
                    :store="$store->slug"
                />
            @endif
        @endforeach
    </tbody>
</table>
