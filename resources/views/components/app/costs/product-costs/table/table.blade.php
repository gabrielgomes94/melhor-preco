<table class="table w-100">
    <thead>
        <x-app.costs.product-costs.table.table-header />
    </thead>

    <tbody>
        @foreach($products as $product)
            <x-app.costs.product-costs.table.product-row :product="$product" />
            @if ($product->hasVariations())
                <x-app.costs.product-costs.table.variations-row :variations="$product->getVariations()->get()" />
            @endif
        @endforeach
    </tbody>
</table>
