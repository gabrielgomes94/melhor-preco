<tr class="d-flex">
    <td class="col-1">{{ $product->sku() }}</td>

    <td class="col-4"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="{{ $product->name() }}"
    >
        {{ $product->name() }}
    </td>

    <td class="col-2 ">R$ {{ $product->price() }} </td>

    <td class="col-2">
        <x-pricing.products.utils.profit-text
            preffix="R$"
            value="{{ $product->profit() }}"
        />
    </td>

    <td class="col-2">
        <x-pricing.products.utils.profit-text
            value="{{ $product->margin() }}"
            suffix="%"
        />
    </td>

    <td class="col-1">
        <a  href="{{ route('pricing.products.showByStore', ['store' => $store, 'product_id' => $product->sku()])}}"
            role="button"
        >
            <x-layout.icons.calculator />
        </a>
    </td>
</tr>
