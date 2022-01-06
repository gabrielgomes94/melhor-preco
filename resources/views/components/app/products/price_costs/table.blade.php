<table class="table w-100">
    <thead>
        <x-app.products.price_costs.table-header />
    </thead>

    <tbody>
    @foreach($products as $product)
        <x-app.products.price_costs.product-row :product="$product" />
        @if ($product->hasVariations())
            <x-app.products.price_costs.variations-row :variations="$product->getVariations()->get()" />
        @endif
    @endforeach
    </tbody>
</table>
