<table class="table w-100">
    <thead>
        <x-products.price_costs.table-header />
    </thead>

    <tbody>
    @foreach($products as $product)
        <x-products.price_costs.product-row :product="$product->data()" />

        @if ($product->hasVariations())
            <x-products.price_costs.variations-row :variations="$product->data()->getVariations()->get()" />
        @endif
    @endforeach
    </tbody>
</table>
