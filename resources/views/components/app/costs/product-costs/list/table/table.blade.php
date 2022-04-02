<x-bootstrap.table.bordered-table>
    <thead>
        <x-app.costs.product-costs.list.table.header />
    </thead>

    <tbody>
        @foreach($products as $product)
            <x-app.costs.product-costs.list.table.product-row :product="$product" />
            @if ($product->hasVariations())
                <x-app.costs.product-costs.list.table.variations-row :variations="$product->getVariations()->get()" />
            @endif
        @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
