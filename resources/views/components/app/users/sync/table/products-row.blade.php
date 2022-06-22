<tr class="">
    <td>
        <h6>Produtos</h6>
    </td>
    <td>
        {{ $products['quantity'] }}
    </td>
    <td>
        {{ $products['syncedAt'] }}
    </td>
    <td>
        <x-bootstrap.forms.form.post action="{{ route($products['route']) }}">
            <button class="btn btn-primary" type="submit">
                Sincronizar produtos

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
