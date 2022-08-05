<tr class="">
    <td colspan="3">
        <h6>Categorias</h6>
    </td>
    <td colspan="1">
        {{ $categories['quantity'] }}
    </td>
    <td colspan="1">
        {{ $categories['syncedAt'] }}
    </td>
    <td colspan="1">
        <x-bootstrap.forms.form.put action="{{ route('categories.sync') }}">
            <button class="btn btn-primary m-0 w-100" type="submit">
                Sincronizar categorias

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.put>
    </td>
</tr>
