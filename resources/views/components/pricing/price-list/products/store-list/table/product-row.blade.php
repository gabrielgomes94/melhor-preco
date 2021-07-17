<tr>
    <th scope="row">{{ $product->sku() }}</th>
    <td> {{ $product->name() }} </td>
    <td>R$ {{ $product->price() }} </td>
    <td>
        <x-pricing.products.utils.profit-text
            preffix="R$"
            value="{{ $product->profit() }}"
        />
    </td>
    <td>
        <x-pricing.products.utils.profit-text
            value="{{ $product->margin() }}"
            suffix="%"
        />
    </td>
    <td>
        <x-utils.navigation-button
            :route="route('pricing.products.showByStore', [
                        'store' => $store,
                        'product_id' => $product->sku()
                    ])"
            label="Calcular"
        />
    </td>
</tr>
