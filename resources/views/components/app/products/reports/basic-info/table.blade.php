<x-bootstrap.table.bordered-table>
    <tbody>
        <tr>
            <th colspan="1">
                <b>SKU</b>
            </th>
            <td colspan="2">
                {{ $product['sku'] }}
            </td>
        </tr>

        <tr>
            <th colspan="1">
                <b>Nome</b>
            </th>
            <td colspan="2">
                {{ $product['name'] }}
            </td>
        </tr>

        <tr>
            <th colspan="1">
                <b>Categoria</b>
            </th>
            <td colspan="2">
                {{ $product['category'] }}
            </td>
        </tr>

        <tr>
            <th colspan="1">
                <b>Dimensões (L x A x P)</b>
            </th>
            <td colspan="2">
                {{ $product['dimensions'] }}
            </td>
        </tr>

        <tr>
            <th colspan="1">
                <b>Peso</b>
            </th>
            <td colspan="2">
                {{ $product['weight'] }}
            </td>
        </tr>

        <tr>
            <th colspan="1">
                <b>Estoque atual</b>
            </th>
            <td colspan="2">
                {{ $product['quantity'] }}
            </td>
        </tr>
    </tbody>
</x-bootstrap.table.bordered-table>
