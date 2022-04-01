<x-bootstrap.table.bordered-table>
    <thead>
    <tr>
        <th colspan="1">SKU</th>
        <th colspan="4">Nome</th>
        <th colspan="2">Observações</th>
        <th colspan="1">Vendas</th>
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
                <div class="d-flex flex-column">
                    <x-bootstrap.forms.check.checkbox
                        label="3 ou mais imagens"
                        active="{{ $product['checklist']['hasManyImages'] }}"
                        disabled="true"
                    />

                    <x-bootstrap.forms.check.checkbox
                        label="Postado no Mercado Livre"
                        active="{{ $product['checklist']['postedOnMercadoLivre'] }}"
                        disabled="true"
                    />

                    <x-bootstrap.forms.check.checkbox
                        label="Postado no Magalu"
                        active="{{ $product['checklist']['postedOnMagalu'] }}"
                        disabled="true"
                    />

                    <x-bootstrap.forms.check.checkbox
                        label="Postado no Shopee"
                        active="{{ $product['checklist']['postedOnShopee'] }}"
                        disabled="true"
                    />
                </div>
            </td>

            <td colspan="1">
                {{ $product['sales'] }}
            </td>
        </tr>
    @endforeach
    </tbody>
</x-bootstrap.table.bordered-table>
