@foreach ($products as $product)
    <tr>
        <td>
            {{ $product['sku'] }}
        </td>

        <td>
            {{ $product['name'] }}
        </td>

        <td>{{ $product['count'] }}</td>
        <td>{{ $product['average_price'] }}</td>

        <td>
            {{ $product['average_profit'] }}
        </td>

        <td>
            {{ $product['average_margin'] }}
        </td>

        <td>
            {{ $product['total_revenue'] }}
        </td>

        <td>
            {{ $product['total_profit'] }}
        </td>
    </tr>
@endforeach
