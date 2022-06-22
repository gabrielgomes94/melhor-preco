<tr class="">
    <td colspan="3">
        <h6>Notas Fiscais de Entrada</h6>
    </td>
    <td colspan="1">
        {{ $purchaseInvoices['quantity'] }}
    </td>
    <td colspan="1">
        {{ $purchaseInvoices['syncedAt'] }}

    </td>
    <td colspan="1">
        <x-bootstrap.forms.form.post action="{{ route($purchaseInvoices['route']) }}">
            <button class="btn btn-primary m-0 w-100" type="submit">
                Sincronizar notas

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
