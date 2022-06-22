<tr class="">
    <td colspan="3">
        <h6>Preços</h6>
    </td>
    <td colspan="1">
        {{ $prices['quantity'] }}
    </td>
    <td colspan="1">
        {{ $prices['syncedAt'] }}
    </td>
    <td colspan="1">
        <x-bootstrap.forms.form.post action="{{ route($prices['route']) }}">
            <button class="btn btn-primary m-0 w-100" type="submit">
                Sincronizar preços

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
