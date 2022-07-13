<tr>
    <td colspan="1">
        <x-bootstrap.links.link :route="route('products.reports.show', ['sku' => $product['sku']])">
            {{ $product['sku'] }}
        </x-bootstrap.links.link>
    </td>

    <td colspan="4"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="{{ $product['name'] }}"
    >
        {{ $product['name'] }}
    </td>

    <td colspan="2">R$ {{ $product['price'] }} </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            preffix="R$"
            value="{{ $product['profit'] }}"
        />
    </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $product['margin'] }}"
            suffix="%"
        />
    </td>

    <td colspan="1">
        {{ $product['quantity'] }}
    </td>

    <td colspan="1">
        <a  href="{{
            route('pricing.products.calculate', ['store_slug' => $store, 'product_id' => $product['sku']])
            }}"'
            role="button"
        >
            <x-app.base.icons.calculator />
        </a>
    </td>
</tr>
