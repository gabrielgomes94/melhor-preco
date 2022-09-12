<tr class="collapse multi-collapse-product-{{ $product['parentSku'] }}">
    <td colspan="1"></td>

    <td colspan="4" class="table-secondary">
        {{ $product['sku'] }} - {{ $product['name'] }}
    </td>

    <td colspan="2" class="table-secondary">
        {{ $product['price'] ?? null}}
    </td>

    <td colspan="2" class="table-secondary">
        <x-app.pricing.products.utils.profit-text
            value="{{ $product['profit'] ?? null }}"
        />
    </td>

    <td colspan="2" class="table-secondary">
        <x-app.pricing.products.utils.profit-text
            value="{{ $product['margin'] ?? null}}"
        />
    </td>

    <td colspan="1" class="table-secondary">
        {{ $product['quantity'] }}
    </td>

    <td colspan="1" class="table-secondary">
        <a  href="{{
                route('pricing.products.calculate', [
                    'store_slug' => $marketplaceSlug,
                    'product_id' => $product['sku']
                ])
            }}"
            role="button"
        >
            <x-app.base.icons.calculator />
        </a>
    </td>
</tr>
