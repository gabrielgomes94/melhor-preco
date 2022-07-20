<tr>
    <td colspan="1"></td>

    <td colspan="4">
        {{ $product['sku'] }} - {{ $product['name'] }}
    </td>

    <td colspan="2">
        {{ $price ?? null}}
    </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $profit ?? null }}"
        />
    </td>

    <td colspan="2">
        <x-app.pricing.products.utils.profit-text
            value="{{ $margin ?? null}}"
        />
    </td>

    <td colspan="1">
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
