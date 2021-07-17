<table class="table table-bordered table-hover">
    <thead>
        <x-pricing.price-list.products.custom-list.table.header
            :stores="$stores"
        />
    </thead>
    <tbody>
    @foreach($products as $product)
        <x-pricing.price-list.products.custom-list.table.product-row
            :product="$product"
            :priceList="$priceList"
            :stores="$stores"
        />

        @if($product->hasVariations())
            <x-pricing.price-list.products.custom-list.table.variations-row
                :variations="$product->variations()"
                :priceList="$priceList"
                :stores="$stores"
            />
        @endif
    @endforeach
    </tbody>
</table>