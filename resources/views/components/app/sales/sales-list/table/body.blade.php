@foreach ($saleOrders as $saleOrder)
    <tr>
        <td>
            <x-template.links.link :route="route('sales.show', $saleOrderId)">
                {{ $saleOrder['saleOrderCode'] }}
            </x-template.links.link>
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
            R$ {{ $saleOrder['value'] }}
        </td>

        <td>
            R$ {{ $saleOrder['profit'] }}
        </td>

        <td>
            {{ $saleOrder['status'] }}
        </td>
    </tr>
@endforeach
