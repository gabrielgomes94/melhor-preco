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
        <tr>
            <th scope="row">{{ $product->sku }}</th>
            <td> {{ $product->name }} </td>
            <td>R$ {{ $product->value }} </td>
            <td>
                <x-pricing.products.utils.profit-text
                    preffix="R$"
                    value="{{ $product->profit }}"
                />
            </td>
            <td>
                <x-pricing.products.utils.profit-text
                    value="{{ $product->margin }}"
                    suffix="%"
                />
            </td>
            <td>
                <x-utils.navigation-button
                    :route="route('pricing.products.showByStore', [
                        'store' => $store->slug,
                        'product_id' => $product->sku
                    ])"
                    label="Calcular"
                />
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
