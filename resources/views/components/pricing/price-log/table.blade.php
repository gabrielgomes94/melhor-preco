<div class="m-4">
    <table class="table w-100">
        <thead>
            <tr>
                <th scope="col">SKU</th>
                <th scope="col">Nome</th>
                <th scope="col">Preço</th>
                <th scope="col">Lucro</th>
                <th scope="col">Última Atualização</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ $product->toArray()['sku'] }}</th>
                    <td scope="row">{{ $product->toArray()['name'] }}</td>
                    <td scope="row">{{ $product->toArray()['price'] }}</td>
                    <td scope="row">{{ $product->toArray()['profit'] }}</td>
                    <td scope="row">{{ $product->toArray()['updatedAt'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
