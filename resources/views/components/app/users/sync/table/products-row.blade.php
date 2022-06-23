<tr class="">
    <td colspan="3">
        <h6>Produtos</h6>
    </td>
    <td colspan="1">
        {{ $products['quantity'] }}
    </td>
    <td colspan="1">
        {{ $products['syncedAt'] }}
    </td>
    <td colspan="1">
        <x-bootstrap.forms.form.put action="{{ route($products['route']) }}">
            <button class="btn btn-primary m-0 w-100" type="submit">
                Sincronizar produtos

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.put>
    </td>
</tr>
