@foreach ($saleOrders as $saleOrder)
    <tr>
        <td>
            <x-bootstrap.links.link :route="route('sales.show', $saleOrder['saleOrderCode'])">
                {{ $saleOrder['saleOrderCode'] }}
            </x-bootstrap.links.link>
        </td>

        <td>
            {{ $saleOrder['selledAt'] }}
        </td>

        <td class="text-break"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            title="{{ $saleOrder['productsInTooltip'] }}"
            colspan="4"
        >
            @foreach ($saleOrder['products'] as $product)
                <x-bootstrap.links.link :route="route('products.reports.show', $product['sku'])">
                    {{ $product['formattedName'] }} <br>
                </x-bootstrap.links.link>
            @endforeach
        </td>
        <td colspan="2">{{ $saleOrder['store'] }}</td>

        <td>
            {{ $saleOrder['value'] }}
        </td>

        <td>
            {{ $saleOrder['profit'] }}
        </td>

        <td>
            {{ $saleOrder['status'] }}
        </td>
    </tr>
@endforeach
