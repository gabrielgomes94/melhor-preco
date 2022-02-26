<x-bootstrap.table.bordered-table>
    <thead>
        <tr>
            <th colspan="1">Marketplace</th>
            <th colspan="1">Preço</th>
            <th colspan="1">Lucro</th>
            <th colspan="1">Margem</th>
            <th colspan="1"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $price)
            <tr>
                <th colspan="1">
                    <b>{{ $price['marketplaceName'] }}</b>
                </th>
                <td colspan="1">
                    {{ $price['value'] }}
                </td>
                <td colspan="1">
                    {{ $price['profit'] }}
                </td>
                <td colspan="1">
                    {{ $price['margin'] }}
                </td>
                <td>
                    <a  href="{{
                            route(
                                'pricing.products.showByStore',
                                [
                                    'store_slug' => $price['marketplaceSlug'],
                                    'product_id' => $price['productSku']
                                ]
                            )
                           }}"
                        role="button"
                    >
                        <x-app.base.icons.calculator />
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
