<x-bootstrap.table.bordered-table>
    <thead>
    <tr>
        <th colspan="1">SKU</th>
        <th colspan="4">Nome</th>
        <th colspan="2">Número de Imagens</th>
        <th colspan="2">Vendas</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($data as $product)
        <tr>
            <th colspan="1">
                <x-bootstrap.links.link :route="route('products.reports.show', ['sku' => $product['sku']])">
                    {{ $product['sku'] }}
                </x-bootstrap.links.link>
            </th>
            <td colspan="4">
                {{ $product['name'] }}
            </td>
            <td colspan="2">
                {{ $product['imagesCount'] }}
            </td>
            <td colspan="2">
                {{ $product['sales'] }}
            </td>
        </tr>
    @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
