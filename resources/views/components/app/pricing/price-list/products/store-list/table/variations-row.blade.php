<tr class="d-flex">
    <td colspan="1"></td>

    <td colspan="4">
        {{ $sku }} - {{ $name }}
    </td>

    <td colspan="2">
        R$ {{ $price }}
    </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            preffix="R$"
            value="{{ $profit }}"
        />
    </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $margin }}"
            suffix="%"
        />
    </td>

    <td colspan="1">
        <a  href="{{ route('pricing.products.calculate', ['store' => $store, 'product_id' => $sku])}}"
            role="button"
        >
            <x-app.base.icons.calculator />
        </a>
    </td>
</tr>
