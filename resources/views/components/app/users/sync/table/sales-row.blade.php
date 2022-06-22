<tr class="">
    <td>
        <h6>Vendas</h6>
    </td>
    <td>
        {{ $sales['quantity'] }}
    </td>
    <td>
        {{ $sales['syncedAt'] }}
    </td>
    <td>
        <x-bootstrap.forms.form.post action="{{ route($sales['route']) }}">
            <button class="btn btn-primary" type="submit">
                Sincronizar vendas

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
