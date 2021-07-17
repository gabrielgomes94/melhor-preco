<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th scope="col">SKU</th>
            <th scope="col">Produto</th>
            <th scope="col">Preço</th>
            <th scope="col">Lucro</th>
            <th scope="col">Margem</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <x-pricing.products.single-store.product-row
            :product="$product"
            :store="$store->slug"
        />

        @if ($product->hasVariations())
            <x-pricing.products.single-store.variations-row
                :variations="$product->variations()"
                :store="$store->slug"
            />
        @endif
    @endforeach
    </tbody>
</table>
