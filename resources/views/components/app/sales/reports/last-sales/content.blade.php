<table class="table">
    <thead>
    <tr>
        <th colspan="1">Data</th>
        <th colspan="1">Marketplace</th>
        <th colspan="1">Quantidade</th>
        <th colspan="1">Valor</th>
        <th colspan="1">Lucro</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($data['lastSales'] ?? [] as $saleData)
        <tr>
            <td>{{ $saleData['saleDate'] }}</td>
            <td>{{ $saleData['marketplace'] }}</td>
            <td>{{ $saleData['quantity'] }}</td>
            <td>{{ $saleData['value'] }}</td>
            <td>{{ $saleData['profit'] }}</td>
        </tr>
    @endforeach

{{--    <tr>--}}
{{--        <td>Total</td>--}}
{{--        <td>{{ $data['total']['value'] }}</td>--}}
{{--        <td>{{ $data['total']['quantity'] }}</td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
    </tbody>
</table>
