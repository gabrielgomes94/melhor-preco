<tr>
    <td colspan="1">
        <x-bootstrap.links.link :route="route('products.reports.show', ['sku' => $sku])">
            {{ $sku }}
        </x-bootstrap.links.link>
    </td>

    <td colspan="4"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="{{ $name }}"
    >
        {{ $name }}
    </td>

    <td colspan="2">R$ {{ $price }} </td>

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
        {{ $quantity }}
    </td>

    <td colspan="1">
        <a  href="{{ route('pricing.products.calculate', ['store_slug' => $store, 'product_id' => $sku])}}"
            role="button"
        >
            <x-app.base.icons.calculator />
        </a>
    </td>
</tr>
