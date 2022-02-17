<table class="table">
    <thead>
        <tr>
            <th colspan="1">Canal de Vendas</th>
            <th colspan="1">Faturamento</th>
            <th colspan="1">Quantidade</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data['salesByMarketplace'] ?? [] as $saleData)
            <tr>
                <td>{{ $saleData['storeName'] }}</td>
                <td>{{ $saleData['value'] }}</td>
                <td>{{ $saleData['quantity'] }}</td>

            </tr>
        @endforeach

        <tr>
            <td>Total</td>
            <td>{{ $data['total']['value'] }}</td>
            <td>{{ $data['total']['quantity'] }}</td>
        </tr>
    </tbody>
</table>
