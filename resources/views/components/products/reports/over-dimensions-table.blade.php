<table class="table w-100">
    <thead>
    <tr>
        <th scope="col" class="w-10">SKU</th>
        <th scope="col" class="w-10">Nome</th>
        <th scope="col" class="w-10">Profundidade</th>
        <th scope="col" class="w-10">Largura</th>
        <th scope="col" class="w-10">Altura</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->sku() }}</td>
            <td>{{ $product->name() }}</td>
            <td>{{ $product->dimensions()->depth() }}</td>
            <td>{{ $product->dimensions()->width() }}</td>
            <td>{{ $product->dimensions()->height() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
