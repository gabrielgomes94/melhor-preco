<tr class="">
    <td colspan="3">
        <h6>Vendas</h6>
    </td>
    <td colspan="1">
        {{ $sales['quantity'] }}
    </td>
    <td colspan="1">
        {{ $sales['syncedAt'] }}
    </td>
    <td colspan="1">
        <x-bootstrap.forms.form.post action="{{ route('sales.sync') }}">
            <button class="btn btn-primary m-0 w-100" type="submit">
                Sincronizar vendas

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
