<div class="m-4">
    <table class="table w-100">
        <thead>
            <tr class="d-flex">
                <th class="col-1">SKU</th>
                <th class="col-4">Nome</th>
                <th class="col-2">Preço</th>
                <th class="col-2">Lucro</th>
                <th class="col-3">Última Atualização</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="d-flex">
                    <th class="col-1">{{ $product['sku'] }}</th>
                    <td
                        class="col-4"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="{{ $product['name'] }}"
                    >
                        {{ $product['name'] }}
                    </td>
                    <td class="col-2">R$ {{ $product['value'] }}</td>
                    <td class="col-2">R$ {{ $product['profit'] }}</td>
                    <td class="col-3">{{ $product['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
