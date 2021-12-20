<table class="table table-hover w-100 px-2 price-list-table">
    <thead >
        <x-app.pricing.price-list.products.store-list.table.header />
    </thead>

    <tbody>
        @foreach($products as $product)
            <x-app.pricing.price-list.products.store-list.table.product-row
                :product="$product"
                :store="$store->slug()"
            />

            @if ($product->hasVariations())
                @foreach($product->getVariations() as $variation)
                    <x-app.pricing.price-list.products.store-list.table.variations-row
                        :product="$variation"
                        :store="$store->slug()"
                    />
                @endforeach
            @endif
        @endforeach
    </tbody>
</table>
