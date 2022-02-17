<table class="table">
    <thead>
    <tr>
        <th colspan="1">Data</th>
        <th colspan="1">Marketplace</th>
        <th colspan="1">Quantidade</th>
        <th colspan="1">Valor</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($data['lastSales'] ?? [] as $saleData)
        <tr>
            <td>{{ $saleData['saleDate'] }}</td>
            <td>{{ $saleData['marketplace'] }}</td>
            <td>{{ $saleData['quantity'] }}</td>
            <td>{{ $saleData['value'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
