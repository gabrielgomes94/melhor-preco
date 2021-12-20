<tr class="d-flex">
    <td class="col-1">{{ $sku }}</td>

    <td class="col-4"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="{{ $name }}"
    >
        {{ $name }}
    </td>

    <td class="col-2 ">R$ {{ $price }} </td>

    <td class="col-2">
        <x-app.pricing.products.utils.profit-text
            preffix="R$"
            value="{{ $profit }}"
        />
    </td>

    <td class="col-2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $margin }}"
            suffix="%"
        />
    </td>

    <td class="col-1">
        <a  href="{{ route('pricing.products.showByStore', ['store_slug' => $store, 'product_id' => $sku])}}"
            role="button"
        >
            <x-layout.icons.calculator />
        </a>
    </td>
</tr>
