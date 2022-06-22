<tr class="">
    <td>
        <h6>Notas Fiscais de Entrada</h6>
    </td>
    <td>
        {{ $purchaseInvoices['quantity'] }}
    </td>
    <td>
        {{ $purchaseInvoices['syncedAt'] }}

    </td>
    <td>
        <x-bootstrap.forms.form.post action="{{ route($purchaseInvoices['route']) }}">
            <button class="btn btn-primary" type="submit">
                Sincronizar notas fiscais

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
