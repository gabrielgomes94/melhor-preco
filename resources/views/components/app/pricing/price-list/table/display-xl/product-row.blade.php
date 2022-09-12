<tr
    type="button"
    data-bs-toggle="collapse"
    data-bs-target=".multi-collapse-product-{{ $product['sku'] }}"
    role="button"
>
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

    <td colspan="2">{{ $product['price'] }} </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $product['profit'] }}"
        />
    </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $product['margin'] }}"
        />
    </td>

    <td colspan="1">
        {{ $product['quantity'] }}
    </td>

    <td colspan="1">
        <div class="d-flex justify-content-between">
            <a  href="{{
            route('pricing.products.calculate', ['store_slug' => $marketplaceSlug, 'product_id' => $product['sku']])
            }}"
                title="Calcular preços"
                role="button"
            >
                <x-app.base.icons.calculator />
            </a>

            @if (!empty($product['variations']))
                <span title="Visualizar variações">
                    <x-app.base.icons.dropdown-arrow />
                </span>
            @endif
        </div>
    </td>
</tr>
