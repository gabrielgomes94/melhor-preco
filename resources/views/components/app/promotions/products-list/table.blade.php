<x-bootstrap.table.bordered-table>
    <thead>
    <tr>
        <th>SKU</th>
        <th>Produto</th>
        <th>Preço com desconto</th>
        <th>Lucro</th>
    </tr>
    </thead>

    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product['sku'] }}</td>
            <td>{{ $product['name'] }}</td>
            <td>{{ $product['value'] }}</td>
            <td>{{ $product['profit'] }}</td>
        </tr>
    @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>