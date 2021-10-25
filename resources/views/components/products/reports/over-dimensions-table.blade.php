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
            <td>{{ $product->data()->getSku() }}</td>
            <td>{{ $product->data()->getDetails()->getName() }}</td>
            <td>{{ $product->data()->getDimensions()->depth() }}</td>
            <td>{{ $product->data()->getDimensions()->width() }}</td>
            <td>{{ $product->data()->getDimensions()->height() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
