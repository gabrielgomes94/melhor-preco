<x-bootstrap.table.bordered-table>
    <thead>
    <tr>
        <th colspan="1">SKU</th>
        <th colspan="4">Produto</th>
        <th colspan="1">Preço com desconto</th>
        <th colspan="1">Lucro</th>
        <th colspan="1">Margem</th>
    </tr>
    </thead>

    <tbody>
    @foreach($products as $product)
        <tr>
            <td colspan="1">{{ $product['sku'] }}</td>
            <td colspan="4">{{ $product['name'] }}</td>
            <td colspan="1">{{ $product['value'] }}</td>
            <td colspan="1">{{ $product['profit'] }}</td>
            <td colspan="1">{{ $product['margin'] }}</td>
        </tr>
    @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
