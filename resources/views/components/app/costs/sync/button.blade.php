<div class="d-flex justify-content-end my-2 mx-1 py-2">
    <x-bootstrap.forms.form.post action="{{ route('costs.sync') }}">
        <button class="btn btn-primary" type="submit">
            Sincronizar

            <x-app.base.icons.icon icon="sync" />
        </button>
    </x-bootstrap.forms.form.post>
</div>
