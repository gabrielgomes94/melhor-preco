<tr class="">
    <td>
        <h6>Categorias</h6>
    </td>
    <td>
        {{ $categories['quantity'] }}
    </td>
    <td>
        {{ $categories['syncedAt'] }}
    </td>
    <td>
        <x-bootstrap.forms.form.put action="{{ route($categories['route']) }}">
            <button class="btn btn-primary m-0" type="submit">
                Sincronizar categorias

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.put>
    </td>
</tr>
