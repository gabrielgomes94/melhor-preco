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
            title="{{ implode(';', $saleOrder['products']) }}"
            colspan="4"
        >
            @foreach ($saleOrder['products'] as $product)
                {{ $product }} <br>
            @endforeach
        </td>
        <td>{{ $saleOrder['store'] }}</td>

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
