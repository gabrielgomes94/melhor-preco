<x-bootstrap.table.bordered-table>
    <thead>
        <tr>
            <th>Data de Início</th>
            <th>Data de Encerramento</th>
            <th>Marketplace</th>
            <th>Campanha</th>
            <th>Desconto</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion['beginDate'] }}</td>
                <td>{{ $promotion['endDate'] }}</td>
                <td>{{ $promotion['marketplace'] }}</td>
                <td>{{ $promotion['name'] }}</td>
                <td>{{ $promotion['discount'] }}</td>

                <td>
                    <a href="{{ route('promotions.show', $promotion['uuid']) }}" class="link-primary">Detalhes</a> <br>
                    Exportar
                </td>
            </tr>
        @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
