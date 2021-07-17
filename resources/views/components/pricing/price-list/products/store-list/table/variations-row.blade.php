@foreach($variations as $variation)
    <tr>
        <td></td>
        <td> {{ $variation->sku() }} - {{ $variation->name() }} </td>
        <td>R$ {{ $variation->price() }} </td>
        <td>
            <x-pricing.products.utils.profit-text
                preffix="R$"
                value="{{ $variation->profit() }}"
            />
        </td>
        <td>
            <x-pricing.products.utils.profit-text
                value="{{ $variation->margin() }}"
                suffix="%"
            />
        </td>
        <td>
            <x-utils.navigation-button
                :route="route('pricing.products.showByStore', [
                            'store' => $store,
                            'product_id' => $variation->sku()
                        ])"
                label="Calcular"
            />
        </td>
    </tr>
@endforeach
