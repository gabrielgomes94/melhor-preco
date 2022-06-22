<tr class="">
    <td>
        <h6>Preços</h6>
    </td>
    <td>
        {{ $prices['quantity'] }}
    </td>
    <td>
        {{ $prices['syncedAt'] }}
    </td>
    <td>
        <x-bootstrap.forms.form.post action="{{ route($prices['route']) }}">
            <button class="btn btn-primary" type="submit">
                Sincronizar preços

                <x-app.base.icons.icon icon="sync" />
            </button>
        </x-bootstrap.forms.form.post>
    </td>
</tr>
