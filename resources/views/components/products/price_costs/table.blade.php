<table class="table w-100">
    <thead>
        <x-products.price_costs.table-header />
    </thead>

    <tbody>
    @foreach($products as $product)
        <x-products.price_costs.product-row :product="$product" />

        @if ($product->hasVariations())
            <x-products.price_costs.variations-row :variations="$product->variations()->get()" />
        @endif
    @endforeach
    </tbody>
</table>
