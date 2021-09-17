@foreach($variations as $variation)
    <tr class="d-flex">
        <td class="col-1"></td>

        <td class="col-4">
            {{ $variation->sku() }} - {{ $variation->name() }}
        </td>

        <td class="col-2">
            R$ {{ $variation->price() }}
        </td>

        <td class="col-2">
            <x-pricing.products.utils.profit-text
                preffix="R$"
                value="{{ $variation->profit() }}"
            />
        </td>

        <td class="col-2">
            <x-pricing.products.utils.profit-text
                value="{{ $variation->margin() }}"
                suffix="%"
            />
        </td>

        <td class="col-1">
            <a  href="{{ route('pricing.products.showByStore', ['store' => $store, 'product_id' => $variation->sku()])}}"
                role="button"
            >
                <x-layout.icons.calculator />
            </a>
        </td>
    </tr>
@endforeach
