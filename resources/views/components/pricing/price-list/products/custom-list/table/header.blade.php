<tr>
    <th scope="col">SKU</th>
    <th scope="col">Produto</th>
    @foreach($stores as $store)
        <th scope="col">{{ $store->name() }}</th>
    @endforeach
    <th scope="col">Ações</th>
</tr>
